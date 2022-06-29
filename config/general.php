<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\helpers\App;

$isDev = App::env('CRAFT_ENVIRONMENT') === 'dev';
$isProd = App::env('CRAFT_ENVIRONMENT') === 'production';

return [
    'defaultWeekStartDay' => 1,
    'omitScriptNameInUrls' => true,
    'devMode' => $isDev,
    'allowUpdates' => $isDev,
    'allowAdminChanges' => $isDev,
    'disallowRobots' => !$isProd,
    // Account
    'useEmailAsUsername' => true,
    'autoLoginAfterAccountActivation' => true,
    'cpTrigger' => App::env('CP_TRIGGER') ?: 'admin',
    'testToEmailAddress' => App::env('SITE_EMAIL'),
    'timezone' => 'Europe/London',
    // Misc
    'enableGql' => false
];
