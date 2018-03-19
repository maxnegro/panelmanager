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

$this->title = Yii::t('backend', 'Update assigned users for panel: {username}', ['username' => $model->adminNameWithSite]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Panel users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="panel-users-update">

    <?php $form = ActiveForm::begin() ?>

    <?php echo $form->field($model, 'user_ids')->checkboxList($users)->hint(Yii::t('backend', 'Select users assigned to panel')); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
