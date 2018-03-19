<?php

/* @var $this yii\web\View */

$this->title = 'Panel VNC screen - ' . Yii::$app->name;

use yii\web\View;
use frontend\assets\NoVncAsset;
$asset = NoVncAsset::register($this);

$this->registerMetaTag([
  'http-equiv'=>'refresh',
  'content' => sprintf('1; url=%s/vnc_lite.html?scale=false&resize=true&host=%s&port=%d&&password=%s&path=%s', $asset->baseUrl, $host, $port, $password, $path ),
])
?>
<h1>Loading</h1>
<!-- <iframe src="<?php echo $asset->baseUrl; ?>/vnc_lite.html?scale=true&resize=true&host=192.168.42.72&port=80&path=websockify?cookie=tast" style="width: 100%; height: -webkit-fill-available;"></iframe> -->
