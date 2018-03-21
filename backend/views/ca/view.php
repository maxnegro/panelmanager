<?php

use yii\helpers\Html;
// use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $cert opensslca certificate */
/* @var $certInfo opensslca certificate data decoded */

$this->title = $certInfo['subject']['CN'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'VPN Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ca-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

<pre>
<?= $cert; ?>
</pre>
</div>
