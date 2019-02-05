# Craft CMS 3.x

This is a boilerplate we use internally for Craft CMS 3.x projects. It's built with the intention of a custom gulp tasks as well as using Foundation CSS framework.

Feel free to use / modify / fork.

## Install

`composer create-project madebyshape/craft-3`

## Whats included

- Craft CMS 3.1.x
- Templates
   - Foundation layout
   - Errors / Exceptions
   - Macros
   - Cache
   - Matrix Blocks
   - Freeform
   - Page / Page Types
- Config
   - Custom general config settings
   - Plugin settings (Asset Rev, Imager, Minify etc)
   - Project Config (Using `config/project.yaml`)
- Regularly Used Plugins
   - Imager
   - Super Table
   - SEOMatic
   - Asset Rev
   - Minify
   - CP Nav
   - Wordsmith
   - Default Dashboard
   - Simple Map
   - Mail Gun
   - Redactor
   - Linkit
   - Retour
- .gitignore to ignore specific project files

## Generate .env (If project exists)

`./craft setup`

If using MAMP, ensure the server name is `127.0.0.1` and `Allow network access to MySQL` is enabled in MAMP - https://craftcms.stackexchange.com/questions/23056/craft-cli-rc1-connectivity-issues-with-mamp-pro/23058

## Developers

**MadeByShape** - https://madebyshape.co.uk  
**Jason Mayo** - https://github.com/bymayo / https://bymayo.co.uk
