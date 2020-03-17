<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

/**
 * Blitz config.php
 *
 * This file exists only as a template for the Blitz settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'blitz.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    '*' => [
        'cachingEnabled' => false,
        'includedUriPatterns' => [
            [
                'siteId' => '',
                'uriPattern' => '.*',
            ]
        ],
        'excludedUriPatterns' => [],
        'cacheStorageSettings' => ['folderPath' => '@webroot/cache/blitz'],
        'clearCacheAutomatically' => true,
        'warmCacheAutomatically' => true,
        'refreshCacheAutomaticallyForGlobals' => true
    ],
    'dev' => [
    ],
    'staging' => [
    ],
    'production' => [
        'cachingEnabled' => true
    ]
];
