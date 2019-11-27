<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see craft\config\GeneralConfig
 */

return [
    '*' => [
      // Site / Environment
      'isSystemLive' => true,
      'securityKey' => getenv('SECURITY_KEY'),
      'useProjectConfigFile' => true,
      'siteUrl' => null,
      // Cache
      'enableTemplateCaching' => true,
      'cacheMethod' => 'file',
      'cacheDuration' => 0, // 86400 = 24 Hours
      'cacheElementQueries' => false,
      // Images / Files
      'defaultImageQuality' => '100',
      'extraAllowedFileExtensions' => 'ico,xml,json',
      // Account
      'useEmailAsUsername' => true,
      'autoLoginAfterAccountActivation' => true,
      // URL
      'omitScriptNameInUrls' => true,
      'cpTrigger' => 'admin',
      // Misc
      'timezone' => 'Europe/London',
      'defaultWeekStartDay' => 1,
      'enableCsrfProtection' => true,
      'allowUpdates' => false,
      'backupOnUpdate' => true,
      'errorTemplatePrefix' => '_',
      'enableGql' => false,
      'useSecureCookies' => true,
      // Aliases
      'aliases' => [
         '@assetBaseUrl' => getenv('ASSETS_URL'),
         '@assetBasePath' => getenv('ASSETS_PATH')
      ]
    ],
    'dev' => [
        'devMode' => true,
        'allowUpdates' => true,
        'enableTemplateCaching' => false,
        'testToEmailAddress' => 'development@madebyshape.co.uk'
    ],
    'staging' => [
        'devMode' => true,
        'useProjectConfigFile' => false
    ],
    'production' => [
        'useProjectConfigFile' => false
    ]
];
