<?php

use craft\helpers\App;

return [
    'projectSlug' => App::env('SERVD_PROJECT_SLUG'),
    'securityKey' => App::env('SERVD_SECURITY_KEY'),
    'assetsEnvironment' => App::env('SERVD_ASSET_ENVIRONMENT') ?? 'staging',
    'injectCors' => 1,
    'clearCachesOnSave' => 'never'
];