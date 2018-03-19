<?php

/* @var $this yii\web\View */

$this->title = 'Web VNC screen - ' . Yii::$app->name;

use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$this->registerMetaTag([
  'http-equiv'=>'refresh',
  'content' => '1; url="http://' . $host . ':' . $port . '/' . $path . '"',
]);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!--
based on noVNC example: lightweight example using minimal UI and features
Copyright (C) 2012 Joel Martin
Copyright (C) 2017 Samuel Mannehed for Cendio AB
noVNC is licensed under the MPL 2.0 (see LICENSE.txt)
This file is licensed under the 2-Clause BSD license (see LICENSE.txt).

-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!-- Apple iOS Safari settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
                Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  </head>
  <body>
  <?php $this->beginBody() ?>
  <h1>Loading...</h1>
  <?php $this->endBody() ?>
  </body>
  </html>
