<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Panel */

$this->title = Yii::t('app', 'Create Panel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Panels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
