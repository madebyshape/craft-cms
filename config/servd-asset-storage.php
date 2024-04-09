<?php

use craft\helpers\App;

return [
    'projectSlug' => App::env('SERVD_PROJECT_SLUG'),
    'securityKey' => App::env('SERVD_SECURITY_KEY'),
    'injectCors' => 1,
    'clearCachesOnSave' => 'never',
    'assetsEnvironment' => 'production'
];