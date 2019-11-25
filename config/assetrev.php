<?php
   return array(
      '*' => array(),
      'production' => array(
         'manifestPath' => 'rev-manifest.json',
         'assetsBasePath' => '../' . getenv('PUBLIC_FOLDER') . '/dist/'
      )
   );
