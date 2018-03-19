<?php

// use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

// AppAsset::register($this);
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

// use frontend\assets\NoVncAsset;
// $novnc = NoVncAsset::register($this);
?>
<?php $this->beginPage() ?>
<?= $content; ?>
<?php $this->endPage() ?>
