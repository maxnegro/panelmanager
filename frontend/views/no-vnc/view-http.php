<?php

/* @var $this yii\web\View */

$this->title = 'Web VNC screen - ' . Yii::$app->name;

use yii\web\View;

$this->registerMetaTag([
  'http-equiv'=>'refresh',
  'content' => '1; url="http://' . $host . ':' . $port . '/' . $path . '"',
]);
?>
<!-- <iframe style="width: 100%; height: 800px;" src="http://<?php echo $host . ':' . $port . '/' . $path; ?>"></iframe> -->
<h1>Loading</h1>
