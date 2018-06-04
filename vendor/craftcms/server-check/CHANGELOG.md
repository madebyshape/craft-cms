Changelog
=========

## 1.1.1 - 2017-12-15

### Changed
- Links within requirement descriptions now open in a new window. ([craftcms/cms#2205](https://github.com/craftcms/cms/issues/2205))

## 1.1.0 - 2017-11-10

### Changed
- The requirements checker no longer attempts to parse a DB config file, and will only run DB requirement checks if a valid `dsn` is provided.
- Lots of refactoring

## 1.0.17 - 2017-06-29

### Changed
- `RequirementsChecker::checkWebRoot()` no longer checks if the `plugins/` folder is in the web root, as there is no `plugins/` folder. 

## 1.0.16 - 2017-06-19

### Changed
- `RequirementsChecker::checkWebRoot()` no longer checks if the `app/` folder is in the web root, as there is no `app/` folder.

## 1.0.15 - 2017-06-13

### Changed
- The DOM extension is now mandatory.

## 1.0.14 - 2017-05-07

### Fixed
- Fixed a bug where the script was considering a blank database password to be invalid. ([#4](https://github.com/craftcms/server-check/issues/4))

## 1.0.13 - 2017-05-01

### Changed
- Removed the PHP version requirement from `composer.json`.

## 1.0.12 - 2017-03-19

### Changed
- Craft 3 Beta 8 compatibility.

## 1.0.11 - 2017-03-07

### Fixed
- Fixed a bug where the PHP memory limit check would fail if `memory_limit` was set to `-1`, which means no limit. 

## 1.0.10 - 2017-02-21

### Fixed
- Fixed a bug where the requirements checker would error if the Craft project lived at the root of the file system.

## 1.0.9 - 2017-02-13

### Added
- Added the PHP `password_hash()` function as a mandatory requirement.
- Added the PHP Zip extension as a mandatory requirement.

## 1.0.8 - 2017-02-06

### Changed
- Tweaked keywords in composer.json 

### Fixed
- Fixed a bug where the default database port wasn’t being accounted for when connecting to the database.

## 1.0.7 - 2017-01-30

### Changed
- Updated the `support` properties in composer.json
- Craft 3 no longer requires `mcrypt`.

## 1.0.6 - 2017-01-17

### Added
- Added support for configuring the database port

## 1.0.5 - 2017-01-17

### Fixed
- Fixed a bug where `checkIniSet()` wasn’t undoing a change it made to PHP’s `memory_limit` setting.

## 1.0.4 - 2017-01-17

### Changed
- Craft 3 now requires PHP 7

## 1.0.3 - 2017-01-17

### Changed
- Updated code for latest Craft coding guidelines

### Removed
- Removed check for buggy `iconv` extension

## 1.0.2 - 2016-12-30

### Changed
- Autoloading support in composer.json

## 1.0.1 - 2016-12-30

### Changed
- No longer specifying a minimum stability in composer.json
- MIT license in composer.json

## 1.0.0 - 2016-12-30

Initial release.
