<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
// use common\models\User;
// use common\models\UserProfile;
// use bs\Flatpickr\FlatpickrWidget;
// use vova07\fileapi\Widget as FileApi;

/* @var $this yii\web\View */
/* @var $profile common\models\UserProfile */
/* @var $user backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */

$this->title = Yii::t('backend', 'Update available panels for user: {username}', ['username' => $model->username]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Panels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="user-panels-update">

    <?php $form = ActiveForm::begin() ?>

    <?php echo $form->field($model, 'panel_ids')->checkboxList($panels)->hint(Yii::t('backend', 'Select panels accessible by user')); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
