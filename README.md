<img src="https://github.com/madebyshape/craft-cms/blob/master/src/public/images/favicon.png" width="60">

# Craft CMS 5 Starter

This is a [Craft CMS 5.x](https://github.com/craftcms/cms) starter [MadeByShape](https://madebyshape.co.uk) use internally for projects, that we open sourced so anybody can use it.

## The Stack

- [Craft CMS 5.x](https://craftcms.com) Content management system
- [DDEV](https://ddev.com) Local development environment
- [Vite 5.x](https://vitejs.dev) Front end build tool with HMR
- [Tailwind CSS 4.x](https://tailwindcss.com) Utility-first CSS framework
- [Alpine.js 3.x](https://alpinejs.dev/) Minimal JS framework
- [Mailgun](https://www.mailgun.com/) Email API
- [Servd](https://servd.host) Craft CMS first hosting provider

## Requirements

- [Docker](https://www.docker.com)
- [DDEV](https://ddev.com)

## Features

- Templates
    - Layout templates setup ready with header and footer globals
    - Exception templates for 404, offline/maintenece and generic errors
    - Page templates setup for use with matrix fields
    - Email template for sending prettier system emails (Forgot password etc)
- Config
    - Configs for all Craft CMS plugins
    - Customised general config with required features that hook in to .env vars
- Env
    - Customised .env file with Servd and Mailgun included
- Building
    - HMR
    - CSS and JS minified and purged
    - Favicon is generated and auto inserted into the template
    - Images compressed
    - Sourcemaps generated
- Servd
    - Setup to be used with Servd hosting platform
    - Enabled for using static caching
- Caching
    - Uses Blitz to handle server caching and warming

## Plugins

### Craft CMS

- Blitz
- CKEditor
- Formie
- Imager X
- Mailgun
- Minify
- SEOMatic
- Servd Assets and Helpers
- Sprig
- Vite

## Install

Create an empty folder and CD to it in terminal (If you plan to use Option 1 or 2).

### 1a. Option 1: Composer

If you have composer installed locally, open terminal and run:

```shell
composer create-project madebyshape/craft-cms
```

### 1b. Option 2: Git

You can clone the repo from Github using Git CLI:

```shell
git clone git@github.com:madebyshape/craft-cms.git
```

### 1c. Option 3: Manual

Download a copy of this repo to your computer using the `Code` button above, and choosing `Download ZIP`. Move these files to your empty folder.

### 2. Start DDEV, Install Craft CMS and dependencies

Firstly, edit `.ddev/config.yaml` and change the `name` to your project name.

Then, there are a few CLI commands ([See more](#cli-commands)) we've created that allow starting DDEV, installing Craft CMS and installing dependencies (Node particularly). The one to get you started:

```shell
make install
```

### 3. Starting Vite

Once you've followed step 2 and it's successfully ran through the steps, you'll need to start Vite which allows you to start using front end tooling:

```shell
make dev
```

## Production

When you're ready to go live, make sure you have `npm` installed on the server, then you can run the production command to minify, compress and build the front end assets:

```shell
npm run build
```

## CLI commands

We've create a few commands to make development easier. All these commands are ran in terminal:

| Command | Description |
| -------- | ------- |
| `make install` | Starts DDEV, Install Craft CMS and dependencies. |
| `make setup` | Use when starting to work on your project especially if your working in a team. |
| `make start` | Starts DDEV and Vite development process. |
| `make dev` | Starts Vite development process. |
| `make prod` | Run on production to start Vite build process - minify, compress etc. |
| `make clean` | Removes composer and node files ready for a clean install. |
| `make clean-logs` | Removes log files from /storage/logs for easier debugging. |
| `make update` | Smaller command that runs `ddev exec php craft update all`. |
| `make up` 💅 | Runs project config apply and migrations apply. |
| `make pull-db` | Pulls a database dump from a remote Servd environment into the local database. |
| `make tp` | Launches tableplus |
| `make l` | Launches the site |

## Nice to know

### Database

To access the database inside the DDEV environment, you can use TablePlus. You can use the following command to open TablePlus to export/import:

```shell
ddev tableplus 
or 
make tp
```

### HTTPS recommended

There is a few issues getting Vite, DDEV and Craft CMS running nicely together over HTTP, so always make sure you are using HTTPS. For DDEV just run:

```shell
ddev stop --all
mkcert -install
ddev start
ddev launch
```

## Roadmap
