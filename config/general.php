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
      'isSystemOn' => true,
      'securityKey' => getenv('SECURITY_KEY'),
      // Cache
      'enableTemplateCaching' => true,
      'cacheMethod' => 'file',
      'cacheDuration' => 86400, // 24 Hours
      // Images / Files
      'defaultImageQuality' => '100',
      'extraAllowedFileExtensions' => 'ico,xml,json',
      // Account
      'useEmailAsUsername' => true,
      'testToEmailAddress' => 'development@madebyshape.co.uk',
      'autoLoginAfterAccountActivation' => true,
      // URL
      'omitScriptNameInUrls' => true,
      'cpTrigger' => 'admin',
      // Misc
      'timezone' => 'Europe/London',
      'defaultWeekStartDay' => 1,
      'enableCsrfProtection' => true,
      'allowUpdates' => false,
      'backupOnUpdate' => true

    ],
    'dev' => [
        'siteUrl' => null,
        'devMode' => true,
        'allowUpdates' => true,
        'enableTemplateCaching' => false
    ],
    'staging' => [
        'siteUrl' => null,
        'isSystemOn' => false
    ],
    'production' => [
        'siteUrl' => null

    ]
];
