<?php

   use craft\helpers\App;
   use craft\cloud\Helper as CloudHelper;

   $transformers = [
      'local' => 'craft',
      'servd' => 'servd',
      'craftCloud' => 'craftcloud',
   ];

   return [
      '*' => [
         'transformer' => $transformers[App::env('FILESYSTEM_TYPE')],
         'imagerUrl' => App::env('PRIMARY_SITE_URL') . '/' . App::env('TRANSFORMS_FOLDER'),
         'imagerSystemPath' => App::env('CRAFT_WEB_ROOT') . '/' . App::env('TRANSFORMS_FOLDER'),
         'fallbackImage' => CloudHelper::isCraftCloud() ? CloudHelper::artifactUrl('dist/images/fallback.png') : '@webroot/dist/images/fallback.png',
         'cacheEnabled' => true,
         'cacheDuration' => 31536000, // 1 year
         'cacheDurationRemoteFiles' => 31536000, // 1 year
         'preserveColorProfiles' => true,
         'jpegQuality' => 90,
         'pngCompressionLevel' => 0,
         'resizeFilter' => 'lanczos',
         'hashPath' => true,
         'useCwebp' => false,
         'cwebpPath' => '/usr/bin/cwebp',
         'cwebpOptions' => '-q 90',
         'optimizeType' => 'job',
         'optimizers' => null,
         'optimizerConfig' => [
            'jpegoptim' => [
               'extensions' => ['jpg'],
               'path' => '/usr/bin/jpegoptim',
               'optionString' => '--strip-all -m90 -o -p'
            ],
            'jpegtran' => [
               'extensions' => ['jpg'],
               'path' => '/usr/bin/jpegtran',
               'optionString' => '-optimize -copy none'
            ],
            'mozjpeg' => [
               'extensions' => ['jpg'],
               'path' => '/usr/bin/mozjpeg',
               'optionString' => '-optimize -copy none'
            ],
            'optipng' => [
               'extensions' => ['png'],
               'path' => '/usr/bin/optipng',
               'optionString' => '-preserve -strip all'
            ],
            'pngquant' => [
               'extensions' => ['png'],
               'path' => '/usr/bin/pngquant',
               'optionString' => '--strip --skip-if-larger --quality=85-90 --speed 1'
            ],
            'gifsicle' => [
               'extensions' => ['gif'],
               'path' => '/usr/bin/gifsicle',
               'optionString' => '--optimize=3 --colors 256'
            ]
         ]
      ],
      'dev' => [],
      'staging' => [],
      'production' => [
        'optimizers' => ['jpegoptim', 'jpegtran', 'optipng', 'gifsicle'],
      ]
   ];