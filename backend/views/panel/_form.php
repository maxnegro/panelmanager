<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Panel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'adminName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['vnc'=>'VNC', 'http'=>'WEB'], ['prompt'=>'']) ?>

    <?= $form->field($model, 'ipAddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'port')->textInput() ?>

    <?= $form->field($model, 'vncPassword')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
