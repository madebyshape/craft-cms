<img src="https://github.com/madebyshape/craft-cms/blob/master/src/public/images/favicon.png" width="60">

# Craft CMS 5 Starter

This is a [Craft CMS 5.x](https://github.com/craftcms/cms) starter that [MadeByShape](https://madebyshape.co.uk) use internally for projects. We open sourced it so anybody can use it.

## Contents

-   [The Stack](#the-stack)
-   [Requirements](#requirements)
-   [Features](#features)
-   [Plugins](#plugins)
-   [Install](#install)
-   [Production](#production)
-   [CLI commands](#cli-commands)
-   [Nice to know](#nice-to-know)
    -   [Switching branches](#switching-branches)
    -   [Device Testing with Tailscale](#device-testing-with-tailscale)
    -   [File system type](#file-system-type)
    -   [Database](#database)
    -   [Email](#email)
    -   [HTTPS recommended](#https-recommended)

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
-   Branch Switching
    -   Switch branches with isolated DDEV projects per branch
    -   Automatic snapshots before switching
    -   Auto pulls database from Servd when the new branch is empty

## Plugins

### Craft CMS

-   Blitz
-   CKEditor
-   Formie
-   Imager X
-   LLM Ready
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

| Command                    | Description                               |
| -------------------------- | ----------------------------------------- |
| `make install`             | Full install (DDEV, Craft CMS, npm)       |
| `make setup`               | Pull latest + install dependencies        |
| `make start`               | Start DDEV + Vite                         |
| `make dev`                 | Start Vite dev server                     |
| `make prod`                | Build front-end assets for production     |
| `make update`              | Update Craft CMS + plugins                |
| `make up`                  | Apply project config + migrations         |
| `make npm-install`         | Install npm packages                      |
| `make keys`                | Generate Craft security keys              |
| `make pull-db`             | Pull remote database (Servd)              |
| `make import-db file=...`  | Import a SQL dump                         |
| `make update-search-index` | Rebuild search index                      |
| `make l`                   | Open site in browser                      |
| `make tp`                  | Open TablePlus                            |
| `make mp`                  | Open Mailpit                              |
| `make share`               | Share site via Tailscale (private)        |
| `make funnel`              | Share site via Tailscale Funnel (public)  |
| `make switch-branch <name>`| Switch branch with isolated DDEV project  |
| `make clean`               | Reset vendor + node_modules               |
| `make clean-logs`          | Clear log files                           |
| `make kill-vite`           | Kill Vite processes                       |

## Nice to know

### Switching branches

When you need to work on a different branch without disturbing your current DDEV database, use:

```shell
make switch-branch <branch>
```

This snapshots the current branch's database, stops the project, checks out the target branch, and spins up an isolated DDEV project named `<project>-<branch>` (using `.ddev/config.local.yaml`). If the new branch's database is empty, it's automatically pulled from Servd. Switching back to `master` or `main` removes the local config and returns to the default project.

### Device Testing with Tailscale

You can test your local site on other devices (phones, tablets) using [Tailscale](https://tailscale.com). This gives you a real HTTPS URL that works on any device.

- [Tailscale](https://tailscale.com/download) installed and running on your Mac (the standalone or Homebrew version, **not** the Mac App Store version)
- Funnel requires HTTPS certificates and the `funnel` node attribute enabled in your [Tailscale admin console](https://login.tailscale.com/admin/acls)

The Tailscale commands (see [CLI commands](#cli-commands)) automatically register the Tailscale hostname with DDEV's router and expose the Vite dev server so CSS/JS assets load correctly on remote devices. You'll need two terminals: one for the Tailscale tunnel and one for Vite.

### File system type

The file system type is set in the `.env` file. It can be set to either `local`, `servd` or `craftCloud` depending on where you are hosting your project. `local` is good for local and also production if the files are hosted on the same server.

```shell
FILESYSTEM_TYPE=local
```

### Database

To access the database inside the DDEV environment, you can use TablePlus. You can use the following command to open TablePlus to export/import:

```shell
ddev tableplus
# or
make tp
```

### Email

Locally, all outgoing mail is caught by [Mailpit](https://mailpit.axllent.org) instead of being delivered, so password resets, Formie notifications and the like are safe to test. This is set in the `dev` block of `config/app.php`, which overrides Craft's `mailer` to send over SMTP to Mailpit (`MAILPIT_SMTP_HOSTNAME` / `MAILPIT_SMTP_PORT` in `.env`); edit that block to change or disable it. View caught mail with `ddev mailpit` (or `make mp`).

> **Note:** The CP **Settings → Email → Test** button bypasses this override and uses your real (Mailgun) settings, so it errors locally. To send a test through Mailpit, run `ddev craft mailer/test` instead.

### HTTPS recommended

There are a few issues getting Vite, DDEV and Craft CMS running nicely together over HTTP, so always make sure you are using HTTPS. For DDEV just run:

```shell
ddev stop --all
mkcert -install
ddev start
ddev launch
```
