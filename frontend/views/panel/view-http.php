<?php

/* @var $this yii\web\View */

$this->title = 'Web VNC screen - ' . Yii::$app->name;

use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$this->registerMetaTag([
  'http-equiv'=>'refresh',
  'content' => sprintf('0; url=%s://%s:%d/%s', $scheme, $host, $port , $path),
]);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!-- Apple iOS Safari settings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
