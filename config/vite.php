<?php

use craft\helpers\App;
use craft\cloud\Helper as CloudHelper;

return [
    'useDevServer' => App::env('ENVIRONMENT') === 'dev' || App::env('CRAFT_ENVIRONMENT') === 'dev',
    'devServerInternal' => 'http://localhost:3000/',
    'devServerPublic' => preg_replace('/:\d+/', '', App::env('PRIMARY_SITE_URL')) . ':3000',
    'serverPublic' => CloudHelper::artifactUrl('dist/'),
    'manifestPath' => CloudHelper::isCraftCloud() ? CloudHelper::artifactUrl('dist/manifest.json') : '@webroot/dist/manifest.json',
    'checkDevServer' => true,
    // 'criticalPath' => '@webroot/dist/criticalcss',
    // 'criticalSuffix' =>'_critical.min.css',
];