prod: 
	ddev exec npm run prod

dev: 
	ddev exec npm run dev

install:
	ddev start
	ddev exec npm install
	ddev composer install
	ddev exec php craft install
	@if [ -z "$(SITE_NAME)" ]; then \
		read -p "Site Name: " SITE_NAME; \
	fi; \
	echo "CRAFT_SITE_NAME=\"$$SITE_NAME\"" >> .env; \
	echo "" >> .env; \
	if [ -z "$(SYSTEM_EMAIL)" ]; then \
		read -p "System Email: " SYSTEM_EMAIL; \
	fi; \
	echo "CRAFT_SYSTEM_EMAIL=\"$$SYSTEM_EMAIL\"" >> .env; \
	echo "" >> .env; \
	if [ -z "$(TEST_EMAIL)" ]; then \
		read -p "Test Email: " TEST_EMAIL; \
	fi; \
	echo "CRAFT_TEST_EMAIL=\"$$TEST_EMAIL\"" >> .env; \
	echo "" >> .env; \
	ddev exec php craft plugin/install hyper
	ddev exec php craft plugin/install seomatic
	ddev exec php craft plugin/install vite
	ddev exec php craft plugin/install craft-blitz
	ddev exec php craft plugin/install craft-sprig
	ddev exec php craft plugin/install formie
	ddev exec php craft plugin/install imager-x
	ddev exec php craft plugin/install craft-dynamic-fields
	ddev exec php craft plugin/install craft-dynamic-fields
	ddev launch; \
	echo "Install complete 🎉"

setup: 
	ddev exec git pull
	ddev start
	ddev exec npm install
	ddev composer install
	ddev exec php craft up --interactive=0
	@echo "Setup complete 🎉"
