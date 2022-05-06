# Craft CMS 4.x, Tailwind CSS, VueJS and AlpineJS

This is a [Craft CMS 4.x](https://github.com/craftcms/cms) boilerplate [MadeByShape](https://madebyshape.co.uk) use internally for projects. 

It's built with the intention of being used with [Tailwind CSS](https://tailwindcss.com/), [VueJS](https://vuejs.org/) and [Alpine.js](https://github.com/alpinejs/alpine) frameworks.

It uses both Webpack and Gulp (For now) to build the project.

## Requirements

- PHP 8.0+
- Composer 2.x.x

## Install

1. `composer create-project madebyshape/craft-cms`
2. Don't run, `./craft setup`, instead manually edit the `.env` file.
3. Once the `.env` is filled in, run `./craft install`

## npm Scripts

`npm run dev`
Your go to for local development

`npm run prod`
Generates production assets (Minify, favicon etc). Perfect for running on server.

`npm run setup`
If project already exists, this will pull, migrate and apply project config and run dev tasks


## Whats included

- [Craft CMS 4.x](https://github.com/craftcms/cms)
- CSS
   - [Tailwind CSS 2.0.x](https://tailwindcss.com/)
- Javascript
   - [Vue.js](https://github.com/vuejs)
   - [Alpine.js](https://github.com/alpinejs/alpine)
   - [loadCSS](https://github.com/filamentgroup/loadCSS)
   - [Javascript Cookie](https://github.com/js-cookie/js-cookie)
   - [Vanilla Lazyload](https://github.com/verlok/vanilla-lazyload)
- Templates
   - [Blocks](https://github.com/madebyshape/craft-3#blocks)
   - [Components](https://github.com/madebyshape/craft-3#components)
   - Pages (With dynamic page types)
   - Email
   - Exceptions
   - Plugins
      - Freeform
- Config
   - Customised `.env` file
   - Customised `general.php`
   - Project Config (Using `config/project.yaml`)
   - Plugin configs:
      - Asset Rev
      - Blitz
      - Freeform
      - Imager X
      - Minify
      - SEOMatic
- Plugins
   - Asset Rev
   - Blitz
   - Default Dashboard
   - Freeform
   - Imager X
   - Link Field
   - Minify
   - Redactor
   - Retour
   - SEOMatic
   - Super Table
- Extras
   - Scripts (To pull assets, db etc from different environments)
   - .gitignore
      - Gulp / Packages
      - SASS
      - Javascript
      - OS Files
      - Craft CMS
      - Caching
      - Asset Source Folders
      - Log files
      - Editor directories and files

## Terminology

### Components
Components are small bits of a template, e.g. a button, input field that then either make up a block or a full template. Use the `components` folder and name each component file by it's use case e.g. `inputField.twig`.

Make sure to describe each component at the top of each component file so other developers know how it is used. If the component accepts any attributes, make sure you include a description of these at the top of each component (Camel Case) file (See the `components/_example.twig`) file.

### Blocks
Blocks are large chunks of markup, or made up of smaller components. E.g. a block could be a form, with button and input field components included. Use the `blocks` folder and name each component file (Camel Case) by it's use case e.g. `largeForm.twig` (If a SASS file exists for a block, use the same file name).

Blocks ideally should be selectable via a Matrix Field so CP users can pick and choose these per template. In some cases this might not be possible though, e.g. if the page is dynamically generated.

## Roadmap

[] Use Webpack solely instead of a mixture of Webpack and Gulp
[] Add Google Workbox
[] rel="preload" fonts via a Webpack task
[] Move some Twig components in to VueJS 

## Developers

**MadeByShape** - https://madebyshape.co.uk  
**Jason Mayo** - https://github.com/bymayo / https://bymayo.co.uk