<?php

use craft\helpers\App;
use craft\cloud\Helper as CloudHelper;

return [
    'useDevServer' => App::env('ENVIRONMENT') === 'dev' || App::env('CRAFT_ENVIRONMENT') === 'dev',
    'devServerInternal' => 'http://localhost:3000/',
    'devServerPublic' => (function () {
        // Explicit override, e.g. remote/VM environments where the browser
        // reaches Vite on a different host than the site.
        if ($explicit = App::env('VITE_DEV_SERVER_PUBLIC')) {
            return $explicit;
        }

        // Tailscale share/funnel (`make share` / `make funnel`).
        if ($host = App::env('TAILSCALE_HOST')) {
            return 'https://' . $host . ':8443';
        }

        // Plain local DDEV.
        return preg_replace('/:\d+/', '', App::env('PRIMARY_SITE_URL')) . ':3000';
    })(),
    'serverPublic' => CloudHelper::artifactUrl('dist/'),
    'manifestPath' => CloudHelper::isCraftCloud() ? CloudHelper::artifactUrl('dist/manifest.json') : '@webroot/dist/manifest.json',
    'checkDevServer' => true,
    // 'criticalPath' => '@webroot/dist/criticalcss',
    // 'criticalSuffix' =>'_critical.min.css',
];