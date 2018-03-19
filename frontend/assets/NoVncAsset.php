<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class NoVncAsset extends AssetBundle
{
  public $sourcePath = '@bower/no-vnc';
  public $css = [
    'app/styles/lite.css',
  ];
  public $js = [
    'vendor/promise.js',
    // 'lib/rfb.js',
  ];
  public $depends = [
      // 'yii\web\JqueryAsset',
      // 'yii\jui\JuiAsset',
      // 'yii\bootstrap\BootstrapPluginAsset',
      // 'common\assets\FontAwesome',
      // 'common\assets\JquerySlimScroll',
  ];
  /**
   * @inherit
   */
  // public $publishOptions = [
  //         'only' => [
  //           "app/*",
  //           "app/styles/*",
  //           "core/*",
  //             "vendor/*"
  //         ],
  //         'except' => [
  //             // "less",
  //             // "scss",
  //             // "src",
  //         ],
  // ];

}
