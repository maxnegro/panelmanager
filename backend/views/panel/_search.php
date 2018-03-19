<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PanelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'adminName') ?>

    <?= $form->field($model, 'userName') ?>

    <?= $form->field($model, 'site') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'ipAddress') ?>

    <?php // echo $form->field($model, 'port') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
