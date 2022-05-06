<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see craft\config\GeneralConfig
 */

use craft\helpers\App;

return [
    '*' => [
      // Site / Environment
      'isSystemLive' => true,
      'allowAdminChanges' => false,
      'securityKey' => App::env('SECURITY_KEY'),
      // Images
      'defaultImageQuality' => '100',
      'transformGifs' => false,
      'preserveImageColorProfiles' => true,
      'preserveCmykColorspace' => true,
      'optimizeImageFilesize' => false,
      'generateTransformsBeforePageLoad' => true,
      'maxUploadFileSize' => '100M',
      // 'imageDriver' => 'imagick',
      // Account
      'useEmailAsUsername' => true,
      'autoLoginAfterAccountActivation' => true,
      // URL
      'omitScriptNameInUrls' => true,
      'cpTrigger' => App::env('CP_TRIGGER') ?: 'admin',
      // Misc
      'allowUpdates' => false,
      'backupOnUpdate' => true,
      'errorTemplatePrefix' => '_',
      'enableGql' => false,
      'disallowRobots' => true,
      'devMode' => true,
      'defaultSearchTermOptions' => [
        'subLeft' => true,
        'subRight' => true
      ],
      // Aliases
      'aliases' => [
         '@assetBaseUrl' => App::env('ASSETS_URL'),
         '@assetBasePath' => App::env('ASSETS_PATH')
      ]
    ],
    'dev' => [
        'allowUpdates' => true,
        'enableTemplateCaching' => false,
        'testToEmailAddress' => App::env('SITE_EMAIL'),
        'allowAdminChanges' => true
    ],
    'staging' => [],
    'production' => [
        'useSecureCookies' => true,
        'disallowRobots' => false,
        'devMode' => false
    ]
];
