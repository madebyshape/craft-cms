.PHONY: prod dev install setup clean npm-install share funnel switch-branch import-on-empty

BRANCH := $(shell git rev-parse --abbrev-ref HEAD)
PROJECT_BASE := $(shell grep -h '^name:' .ddev/config.yaml | awk '{print $$2}')

# Vite 8 + some plugins have peerDependency ranges that still conflict on clean installs.
# Use the same flags we verified work inside DDEV.
NPM_INSTALL_FLAGS ?= --include=optional --legacy-peer-deps

prod: 
	ddev exec npm run build

dev: 
	ddev exec npm run dev

start: 
	ddev start
	ddev exec npm run dev

install:
	ddev start
	ddev exec -- npm install $(NPM_INSTALL_FLAGS)
	ddev composer install
	@if [ ! -f .env ]; then \
		if [ -f .env.example.dev ]; then \
			cp .env.example.dev .env; \
			echo ".env file created from .env.example.dev"; \
		else \
			echo "Error: .env.example.dev file not found"; \
			exit 1; \
		fi \
	fi
	ddev exec mkdir -p web/assets web/transforms
	ddev exec php craft install
	@if [ -z "$(CRAFT_SITE_NAME)" ]; then \
		read -p "Site Name: " site_name; \
		sed -i '' "s/^CRAFT_SITE_NAME=.*/CRAFT_SITE_NAME=\"$$site_name\"/" .env || echo "CRAFT_SITE_NAME=\"$$site_name\"" >> .env; \
	fi; \
	if [ -z "$(CRAFT_SYSTEM_EMAIL)" ]; then \
		read -p "System Email: " system_email; \
		sed -i '' "s/^CRAFT_SYSTEM_EMAIL=.*/CRAFT_SYSTEM_EMAIL=\"$$system_email\"/" .env || echo "CRAFT_SYSTEM_EMAIL=\"$$system_email\"" >> .env; \
		sed -i '' "s/^CRAFT_TEST_TO_EMAIL_ADDRESS=.*/CRAFT_TEST_TO_EMAIL_ADDRESS=\"$$system_email\"/" .env || echo "CRAFT_TEST_TO_EMAIL_ADDRESS=\"$$system_email\"" >> .env; \
	fi; \
	ddev exec php craft up --interactive=0
	ddev exec php craft update all
	ddev launch; \
	echo "Install complete 🎉"

setup: 
	ddev start
	git pull
	ddev exec -- npm install $(NPM_INSTALL_FLAGS)
	ddev composer install
	ddev exec php craft setup/keys
	ddev exec php craft up --interactive=0
	ddev exec npm run dev

clean: 
	rm -rf vendor/
	rm -rf node_modules/
	ddev composer clear-cache
	ddev exec npm cache clean --force
	ddev composer install
	ddev exec -- npm install $(NPM_INSTALL_FLAGS)

clean-logs:
	rm -rf storage/logs/*.log

update: 
	ddev exec php craft update all

pull-db: 
	ddev exec php craft servd-asset-storage/local/pull-database --emptyDatabase

import-db:
ifndef file
	$(error "file" is not set. Usage: make import-db file=path/to/dump.sql.gz)
endif
	ddev import-db --file=$(file)

up: 
	ddev exec php craft up --interactive=0

tp: 
	ddev tableplus

l: 
	ddev launch

keys: 
	ddev exec php craft setup/keys

update-search-index:
	ddev exec php craft resave/entries --update-search-index

mp: 
	ddev mailpit

kill-vite:
	@ddev exec bash -c "pkill -9 -f 'node.*vite'" 2>/dev/null || true
	@echo "Vite processes killed"

npm-install:
	@ddev start
	@ddev exec -- npm install $(NPM_INSTALL_FLAGS)

share:
	ddev tailscale-share

funnel:
	ddev tailscale-funnel

switch-branch:
	@$(eval TARGET := $(filter-out switch-branch,$(MAKECMDGOALS)))
	@if [ -z "$(TARGET)" ]; then echo "Usage: make switch-branch <branch>"; exit 1; fi
	@ddev describe -j 2>/dev/null | grep -q '"status":"running"' \
		&& ddev snapshot --name=$(BRANCH) \
		|| echo "Project not running — skipping snapshot"
	@CURRENT=$$(grep -h '^name:' .ddev/config.local.yaml .ddev/config.yaml 2>/dev/null | head -1 | awk '{print $$2}'); \
	ORIGINAL=$$(grep -h '^name:' .ddev/config.yaml | awk '{print $$2}'); \
	ddev stop --unlist $$CURRENT 2>/dev/null || true; \
	[ "$$CURRENT" != "$$ORIGINAL" ] && ddev stop --unlist $$ORIGINAL 2>/dev/null || true
	git checkout $(TARGET)
	git pull
	@NEW_BRANCH=$$(git rev-parse --abbrev-ref HEAD); \
	if [ "$$NEW_BRANCH" = "master" ] || [ "$$NEW_BRANCH" = "main" ]; then \
		rm -f .ddev/config.local.yaml; \
	else \
		echo "name: $(PROJECT_BASE)-$$NEW_BRANCH" > .ddev/config.local.yaml; \
	fi
	ddev start
	@$(MAKE) clean
	@$(MAKE) import-on-empty

%:
	@:

import-on-empty:
	@TABLES=$$(ddev mysql -N -e "SHOW TABLES" 2>/dev/null | wc -l | tr -d ' '); \
	if [ "$$TABLES" = "0" ]; then \
		echo "Database is empty — pulling from Servd..."; \
		ddev exec php craft servd-asset-storage/local/pull-database; \
		ddev exec php craft up --interactive=0; \
	else \
		echo "Database has $$TABLES tables — skipping import."; \
	fi
