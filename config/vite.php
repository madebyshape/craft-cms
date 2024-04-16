<?php

use craft\helpers\App;

return [
    'useDevServer' => App::env('ENVIRONMENT') === 'dev' || App::env('CRAFT_ENVIRONMENT') === 'dev',
    'manifestPath' => '@webroot/dist/manifest.json',
    'devServerInternal' => 'http://localhost:3000/',
    'devServerPublic' => preg_replace('/:\d+/', '', App::env('PRIMARY_SITE_URL')) . ':3000',
    'serverPublic' => App::env('PRIMARY_SITE_URL') . '/dist/',
    'checkDevServer' => true,
    // 'criticalPath' => '@webroot/dist/criticalcss',
    // 'criticalSuffix' =>'_critical.min.css',
];