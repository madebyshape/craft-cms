# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).

## Unreleased

### Added
- Tailscale device testing with `make share` and `make funnel` commands.
- `TAILSCALE_HOST` env var support in Craft Vite plugin for remote asset loading.
- Mac App Store detection in Tailscale scripts with helpful error message.
- Docker Compose port fix for DDEV router. ([#66](https://github.com/madebyshape/craft-cms/issues/66))

### Changed
- Updated README with Tailscale docs, spelling fixes, and grammar improvements.

### Security
- Updated psy/psysh to v0.12.22. (CVE-2026-25129)
- Updated picomatch to 4.0.4, minimatch to 3.1.5, symfony/process to 6.4.33.

## 5.2.1 - 2026-04-08

### Added
- Tailscale for local device testing.

### Fixed
- README spelling mistakes.
- Production command in README.

## 5.2.0 - 2026-04-07

### Added
- Default `pageBlocksContent` field.

### Changed
- Updated Vite to 8.0.5, picomatch to 4.0.4, minimatch to 3.1.5.
- Updated symfony/process to 6.4.33.

### Security
- Updated psy/psysh to v0.12.22. (CVE-2026-25129)

## 5.1.15 - 2026-04-07

### Fixed
- Docker Compose port configuration issue. ([#66](https://github.com/madebyshape/craft-cms/issues/66))
- Removed exposed license keys.

## 5.1.14 - 2026-04-07

### Changed
- Upgraded to Vite 8.
- Updated Craft CMS and plugins.

## 5.1.13 - 2026-02-03

### Added
- `make import-db` command.
- Mailpit for local email testing.

### Changed
- Updated Craft CMS and plugins.

### Fixed
- Fallback image.
- License keys.

## 5.1.12 - 2026-01-05

### Changed
- Disabled query string caching by default.

### Fixed
- Removed license keys.

## 5.1.11 - 2025-11-18

### Added
- Imager X Craft Cloud plugin.

### Changed
- Updated README with filesystem documentation.

## 5.1.10 - 2025-11-18

### Added
- Craft Cloud filesystem.
- Extra default fields.

### Changed
- Plugin updates.
- Rebuilt project config.
- Simplified `make install` — removed plugin install commands as Composer handles it.

## 5.1.9 - 2025-11-18

### Added
- Craft Cloud support.
- `make update-search-index` command.

### Changed
- Updated Formie version.

### Fixed
- Update search index command.

## 5.1.8 - 2025-10-07

### Added
- `make keys` command.

### Removed
- Dev-specific env var options.

## 5.1.7 - 2025-05-20

### Added
- Transforms directory to `.gitignore`.

### Fixed
- Fonts array issue.

## 5.1.6 - 2025-04-04

### Changed
- Updated Tailwind CSS to 4.1.

## 5.1.5 - 2025-04-02

### Changed
- Updated plugin versions.

## 5.1.4 - 2025-04-02

### Added
- `--emptyDatabase` flag to `make pull-db` command.
- Label to link field.

## 5.1.3 - 2025-03-03

### Added
- `make clean-logs` command.

### Changed
- Added `libvips-dev` to DDEV config to fix Sharp package errors on `make prod`. ([#62](https://github.com/madebyshape/craft-cms/pull/62))

## 5.1.2 - 2025-02-20

### Changed
- Dev and Start make commands.

## 5.1.1 - 2025-02-17

### Removed
- Aspect ratio plugin from README.
- Debug mode from Vite.

## 5.1.0 - 2025-02-14

### Added
- Tailwind CSS 4 support.
- Install commands to `make clean`.

### Changed
- Updated plugins.

### Fixed
- Tailwind 4 source issues.

## 5.0.9 - 2025-02-13

### Fixed
- Spelling mistake on `FILESYSTEM_FOLDER`.

### Removed
- Extra email step.

## 5.0.8 - 2025-02-06

### Added
- Button component.
- Local filesystems and Imager X config options.
- Servd settings.
- Default test base fields and more default fields.
- Fallback image.
- TablePlus and Launch make commands.

### Changed
- Smoothed out install process and added update command on install.

### Fixed
- SEOmatic config.
- Filesystem type on images filesystem.
- Mutagen warning.
- Makefile to overwrite env vars.

### Removed
- Hyper plugin.
- `servd-asset-storage.php`.

## 5.0.7 - 2025-01-28

### Fixed
- License issue.

## 5.0.6 - 2025-01-20

### Added
- `ddev start` to make commands.
- Name to Composer for Packagist.

## 5.0.5 - 2025-01-15

### Added
- `make pull-db` command.
- `make up` command.

### Fixed
- DDEV not started on `make setup`.
- Servd config issues.
- Setup make command with git pull error.

## 5.0.4 - 2025-01-10

### Fixed
- Vite reload issue.
- Server adding multiple ports.

### Changed
- Package name.

## 5.0.3 - 2024-12-20

### Fixed
- Double extension on Vite DDEV YAML.

## 5.0.2 - 2024-12-15

### Changed
- Updated README.

## 5.0.1 - 2024-12-10

### Added
- Vite restart plugin to fix template issues.

### Changed
- Added shell type to commands in README.
- Disabled Critical CSS.

### Fixed
- Setup not running dev command.

## 5.0.0 - 2024-12-01

### Added
- Craft CMS 5 framework.
- DDEV local development environment.
- Vite JS build tool with HMR.
- Tailwind CSS with default utility classes.
- Makefile with install, setup, dev, prod, clean, and update commands.
- CKEditor, Imager X, Mailgun, Servd, and Vite plugins.
- Layout, page, exception, and email templates.
- Favicon generation and image compression.
- Fonts partial and CSS/JS components.
- Custom config files for all plugins.
