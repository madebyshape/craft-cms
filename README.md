# Craft CMS 3.x

This is a boilerplate we use internally for Craft CMS 3.x projects. It's built with the intention of a custom gulp script as well as using Foundation CSS framework.

Feel free to use.

## Install

`composer create-project madebyshape/craft-3`

## Run Migrations

Get the migration scripts from https://github.com/madebyshape/craft-3-build and run to:

- Install Plugins
- Add Default Sections
- Add Default Fieldtypes
- Add Default Asset Volumes

## Generate .env (If project exists)

`./craft setup`

If using MAMP, ensure the server name is `127.0.0.1` and `Allow network access to MySQL` is enabled in MAMP - https://craftcms.stackexchange.com/questions/23056/craft-cli-rc1-connectivity-issues-with-mamp-pro/23058

## Whats included

- Craft CMS 3.1.x
- Templates
   - Foundation base
   - Error / Exception
- Config
   - Custom general config settings
   - Plugin settings (Asset Rev, Imager, Minify etc)
   - Project YAML
- Useful Plugins
- .gitignore to ignore specific project files

## Developers

**MadeByShape** - https://madebyshape.co.uk  
**Jason Mayo** - https://github.com/bymayo
