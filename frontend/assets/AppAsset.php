<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/css/style.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\OpenSans',
        'common\assets\FontAwesome',
    ];

    public function init()
    {
      parent::init();
      if (!Yii::$app->user->isGuest) {
        $theme = empty(Yii::$app->user->identity->userProfile->theme) ? 'default' : Yii::$app->user->identity->userProfile->theme;
        $this->css[] = 'static/themes/' . $theme . '/style.css';
      }
    }
}
