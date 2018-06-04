Craft CMS Plugin Installer for Composer
=======================================

This is the Composer installer for [Craft CMS](https://craftcms.com/) plugins. It implements a new Composer package type named `craft-plugin`, which should be used by all Craft CMS plugins if they are distributed as Composer packages.

Usage
-----

To create a Craft CMS plugin that can be installed with Composer, set the `type` property in your plugin’s composer.json file to `"craft-plugin"`. You will also need to define an `"extra"` object with (at minimum) a `"handle"` key.

```json
{
  "type": "craft-plugin",
  "...": "...",
  "extra": {
    "handle": "foo"
  }
}
```

Here’s the full list of things you can put in the `extra` object:

- `handle` – The plugin handle (required).
- `class` – The primary Plugin class name. If not set, the installer will look for a `Plugin.php` file at each of the `autoload` path roots.
- `basePath` – The base path to your plugin’s source files. This can begin with one of your `autoload` namespaces, formatted as a [Yii alias](http://www.yiiframework.com/doc-2.0/guide-concept-aliases.html) (e.g. `@vendorname/foo`). If not set, the directory that contains your primary Plugin class will be used.    
- `name` – The plugin name. If not set, the package name (sans vendor prefix) will be used.
- `version` - The plugin version. If not set, the current package version will be used.
- `schemaVersion` – The plugin schema version.
- `description` – The plugin description. If not set, the main `description` property will be used.
- `developer` – The developer name. If not set, the first author’s `name` will be used (via the `authors` property).
- `developerUrl` – The developer URL. If not set, the `homepage` property will be used, or toe first author’s `homepage` (via the `authors` property).
- `developerEmail` – The developer support email. If not set, the `support.email` property will be used.
- `documentationUrl` – The plugin’s documentation URL. If not set, the `support.docs` property will be used.
- `changelogUrl` – The plugin’s changelog URL (used to show pending plugin updates and their release notes).
- `downloadUrl` – The plugin’s download URL (used to update manual installations of the plugin).
- `t9nCategory` – The plugin’s translation message category (defaults to the all-lowercase plugin handle).
- `sourceLanguage` – The plugin’s source language (defaults to `en-US`).
- `hasCpSettings` – Whether the plugin has a settings page in the Control Panel (should be `true` or `false`).
- `hasCpSection` – Whether the plugin has its own section in the Control Panel (should be `true` or `false`).
- `components` – Object defining any [component configs](http://www.yiiframework.com/doc-2.0/guide-structure-application-components.html) that should be present on the plugin.
- `modules` – Object defining any [sub-modules](http://www.yiiframework.com/doc-2.0/guide-structure-modules.html) that should be present on the plugin.

Complete Example
----------------

Here’s what a plugin’s complete composer.json file might look like:

```json
{
  "name": "pixelandtonic/foo",
  "description": "Foo plugin for Craft CMS",
  "type": "craft-plugin",
  "license": "MIT",
  "minimum-stability": "dev",
  "support": {
    "email": "support@craftcms.com",
    "docs": "https://pixelandtonic.com/foo/docs"
  },
  "require": {
    "craftcms/cms": "^3.0.0-beta.20"
  },
  "autoload": {
    "psr-4": {
      "pixelandtonic\\foo\\": "src/"
    }
  },
  "extra": {
    "handle": "foo",
    "name": "Foo",
    "developer": "Pixel & Tonic",
    "developerUrl": "https://pixelandtonic.com/",
    "changelogUrl": "https://github.com/pixelandtonic/foo/blob/master/changelog.md",
    "downloadUrl": "https://github.com/pixelandtonic/foo/archive/master.zip"
  }
}
```

In that example,

- `handle` will be `foo`, per the `extra.handle` property.
- `class` will be `pixelandtonic\foo\Plugin` per the `autoload` property (assuming that a `src/Plugin.php` file exists).
- `basePath` will be `path/to/vendor/pixelandtonic/foo/src` (the directory that contains the `pixelandtonic\foo\Plugin` class).
- `name` will be `Foo`, per the `extra.name` property.
- `handle` will be `foo`, per the `name` property.
- `version` will be whatever the current package version is.
- `description` will be `Foo plugin for Craft CMS` per the `description` property.
- `developer` will be `Pixel & Tonic`, per the `extra.developer` property.
- `developerUrl` will be `https://pixelandtonic.com/`, per the `extra.developerUrl` property.
- `developerEmail` will be `support@craftcms.com`, per the `support.email` property.
- `documentationUrl` will be `https://pixelandtonic.com/foo/docs`, per the `support.docs` property.
- `changelogUrl` will be `https://github.com/pixelandtonic/foo/blob/master/changelog.md`, per the `extra.changelogUrl` property.
- `downloadUrl` will be `https://github.com/pixelandtonic/foo/archive/master.zip`, per the `extra.downloadUrl` property.
