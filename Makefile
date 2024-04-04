setup:
	ddev start
	ddev composer install
	ddev craft install
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
	ddev launch; \
	echo "Setup complete 🎉"
