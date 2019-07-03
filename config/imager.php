<?php

   return [
      '*' => [
         'imagerUrl' => getenv('ASSETS_URL') . '/imager',
         'imagerSystemPath' => getenv('ASSETS_PATH') . '/imager',
         'cacheEnabled' => true,
         'cacheDuration' => 31536000, // 1 year
         'cacheDurationRemoteFiles' => 31536000, // 1 year
         'jpegQuality' => 100,
         'pngCompressionLevel' => 0,
         'resizeFilter' => 'lanczos',
         'hashPath' => true,
         'useCwebp' => true,
         'cwebpPath' => '/usr/bin/cwebp',
         'cwebpOptions' => '-q 75',
         'optimizeType' => 'job',
         'optimizers' => ['jpegoptim', 'jpegtran', 'optipng', 'gifsicle'],
         'optimizerConfig' => [
            'jpegoptim' => [
               'extensions' => ['jpg'],
               'path' => '/usr/bin/jpegoptim',
               'optionString' => '--strip-all -m85 -o -p'
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
               'optionString' => '--strip --skip-if-larger --quality=80-85 --speed 1'
            ],
            'gifsicle' => [
               'extensions' => ['gif'],
               'path' => '/usr/bin/gifsicle',
               'optionString' => '--optimize=3 --colors 256'
            ]
         ]
      ],
      'dev' => [
         'useCwebp' => false,
         'optimizers' => null,
         'noop' => true,
         'suppressExceptions' => true,
         'skipExecutableExistCheck' => true
      ],
      'staging' => [
         'useCwebp' => false,
         'optimizers' => null
      ],
      'production' => [
      ]
   ];
