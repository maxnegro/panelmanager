<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create user'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Roles'), ['/rbac/access/role'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Permissions'), ['/rbac/access/permission'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'username',
            // 'auth_key',
            // 'access_token',
            // 'password_hash',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return User::statuses($model->status);
                },
                'filter' => User::statuses(),
            ],
            'ip',
            // 'created_at',
            // 'updated_at',
            // 'action_at',
            [
              'label' => Yii::t('backend', 'Assigned Panels'),
              'value' => function ($model) { return $model->getUserPanels()->count(); },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {panels} {delete}',
                'buttons' => [
                  'update' => function($url) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                    $url,
                    [
                      'title' => Yii::t('backend', 'Update'),
                    ]);
                  },
                  'panels' => function($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-tasks"></span>',
                    ['/user-with-panels/update', 'id' => $model->id],
                    [
                      'title' => Yii::t('backend', 'Panel mapping'),
                      'data-pjax' => 0,
                    ]);
                  },
                ],
            ],
        ],
    ]) ?>

</div>
