Changelog
=========

## 1.5.2 - 2017-07-25

### Fixed
- Fixed a bug where Craft plugin info wasn’t being removed from `craftcms/plugins.php` when a plugin was uninstalled. 

## 1.5.1 - 2017-07-12

### Fixed
- Fixed some PHP errors that could occur when running Composer on PHP < 7.0.

## 1.5.0 - 2017-07-07

### Added
- Added support for setting plugins’ `$developerEmail` property via `support.email` or `extra.developerEmail` in `composer.json`.

### Changed
- Craft 3 Beta 20 compatibility.

## 1.4.0 - 2017-06-19

### Changed
- The installer now reverts the vendor/ folder to its previous state after attempting to install/update an invalid plugin.

## 1.3.1 - 2017-04-04

### Fixed
- Fixed a PHP error that could occur if the `opcache.restrict_api` PHP config setting was enabled.

## 1.3.0 - 2017-03-24

### Changed
- Added Craft 3 Beta 8 support, by checking for `extra.hasCpSettings` rather than `hasSettings`.

## 1.2.0 - 2017-03-22

### Added
- Plugins can now define [sub-modules](http://www.yiiframework.com/doc-2.0/guide-structure-modules.html) via `extra.modules` in their `composer.json` file.

## 1.1.0 - 2017-03-10

### Added
- Added support for setting plugins’ `$t9nCategory` property via `extra.t9nCategory` in `composer.json`.

## 1.0.0 - 2017-01-31

Initial release.
