<img src="https://github.com/madebyshape/craft-cms/blob/master/src/public/images/favicon.png" width="60">

# Craft CMS 5 Starter

This is a [Craft CMS 5.x](https://github.com/craftcms/cms) starter that [MadeByShape](https://madebyshape.co.uk) use internally for projects. We open sourced it so anybody can use it.

## The Stack

-   [Craft CMS 5.x](https://craftcms.com) Content management system
-   [DDEV](https://ddev.com) Local development environment
-   [Vite 8.x](https://vitejs.dev) Front-end build tool with HMR
-   [Tailwind CSS 4.x](https://tailwindcss.com) Utility-first CSS framework
-   [Alpine.js 3.x](https://alpinejs.dev/) Minimal JS framework
-   [Mailgun](https://www.mailgun.com/) Email API
-   [Servd](https://servd.host) Craft CMS first hosting provider
-   [Craft Cloud](https://craft.cloud) Craft CMS hosting provider
-   [Tailscale](https://tailscale.com) Device testing via secure tunnels

## Requirements

-   [Docker](https://www.docker.com)
-   [DDEV](https://ddev.com)
-   [Tailscale](https://tailscale.com/download) (optional, for device testing)

## Features

-   Templates
    -   Layout templates setup ready with header and footer globals
    -   Exception templates for 404, offline/maintenance and generic errors
    -   Page templates setup for use with matrix fields
    -   Email template for sending prettier system emails (Forgot password etc)
-   Config
    -   Configs for all Craft CMS plugins
    -   Customised general config with required features that hook into .env vars
-   Env
    -   Customised .env file with Servd and Mailgun included
-   Building
    -   HMR
    -   CSS and JS minified and purged
    -   Favicon is generated and auto-inserted into the template
    -   Images compressed
    -   Sourcemaps generated
-   Servd
    -   Setup to be used with Servd hosting platform
    -   Enabled for using static caching
-   Craft Cloud
    -   Setup to be used with Craft Cloud hosting provider
    -   Enabled for using artifacts with Vite JS and Imager X
-   Caching
    -   Uses Blitz to handle server caching and warming
-   Device Testing
    -   Test on phones and tablets via Tailscale Share or Funnel
    -   Vite dev server assets served through the tunnel

## Plugins

### Craft CMS

-   Blitz
-   CKEditor
-   Formie
-   Imager X
-   Mailgun
-   Minify
-   SEOMatic
-   Servd Assets and Helpers
-   Craft Cloud Extension
-   Imager X Craft Cloud Transformer
-   Sprig
-   Vite

## Install

Create an empty folder and `cd` to it in your terminal (if you plan to use Option 1 or 2).

### 1a. Option 1: Composer

If you have Composer installed locally, open your terminal and run:

```shell
composer create-project madebyshape/craft-cms
```

### 1b. Option 2: Git

You can clone the repo from GitHub using the Git CLI:

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

Once step 2 has successfully completed, start Vite for front-end tooling:

```shell
make dev
```

## Production

When you're ready to go live, make sure you have `npm` installed on the server, then run the production command to minify, compress and build the front-end assets:

```shell
npm run build
# or
make prod
```

## CLI commands

We've created a few commands to make development easier. All commands are run in your terminal:

| Command                    | Description                                  |
| -------------------------- | -------------------------------------------- |
| `make install`             | Start DDEV, install Craft CMS & dependencies |
| `make setup`               | Pull repo + install deps                     |
| `make start`               | Start DDEV + Vite                            |
| `make dev`                 | Start Vite (HMR)                             |
| `make prod`                | Production build (Vite build)                |
| `make npm-install`         | Run `npm install` inside DDEV                |
| `make clean`               | Remove vendor & node_modules                 |
| `make clean-logs`          | Remove storage logs                          |
| `make update`              | Run Craft updates                            |
| `make up`                  | Apply project config & migrations            |
| `make pull-db`             | Pull database dump into local DB             |
| `make import-db file=...`  | Import a SQL dump into the local DB          |
| `make tp`                  | Launch TablePlus                             |
| `make l`                   | Launch site                                  |
| `make keys`                | Setup Craft project keys                     |
| `make update-search-index` | Rebuild search index                         |
| `make mp`                  | Launch Mailpit                               |
| `make kill-vite`           | Kill running Vite dev processes              |
| `make share`               | Share site over Tailscale (private)          |
| `make funnel`              | Share site via Tailscale Funnel (public)     |

## Device Testing with Tailscale

You can test your local site on other devices (phones, tablets) using [Tailscale](https://tailscale.com). This gives you a real HTTPS URL that works on any device.

- [Tailscale](https://tailscale.com/download) installed and running on your Mac
- For `make share`: Tailscale installed on the test device too
- For `make funnel`: No Tailscale needed on the test device (public URL)
- Funnel requires HTTPS certificates and the `funnel` node attribute enabled in your [Tailscale admin console](https://login.tailscale.com/admin/acls)

The share/funnel commands automatically register the Tailscale hostname with DDEV's router and expose the Vite dev server so CSS/JS assets load correctly on remote devices. Run `make share` or `make funnel` in one terminal and `make dev` in another.

## Nice to know

### File system type

The file system type is set in the `.env` file. It can be set to either `local`, `servd` or `craftCloud` depending on where you are hosting your project. `local` is good for local and also production if the files are hosted on the same server.

```shell
FILESYSTEM_TYPE=local
```

### Database

To access the database inside the DDEV environment, you can use TablePlus. You can use the following command to open TablePlus to export/import:

```shell
ddev tableplus
or
make tp
```

### Email

To access the email inside the DDEV environment, you can use Mailpit. You can use the following command to open Mailpit:

```shell
ddev mailpit
or
make mp
```

### HTTPS recommended

There are a few issues getting Vite, DDEV and Craft CMS running nicely together over HTTP, so always make sure you are using HTTPS. For DDEV just run:

```shell
ddev stop --all
mkcert -install
ddev start
ddev launch
```
