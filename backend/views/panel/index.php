<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PanelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Panels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Panel'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'adminName',
            'userName',
            'site',
            'type',
            'ipAddress',
            'port',
            [
              'label' => Yii::t('backend', 'Assigned Users'),
              'value' => function ($model) { return $model->getUserPanels()->count(); },
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{update} {users} {delete}',
              'buttons' => [
                'users' => function($url, $model) {
                  return Html::a('<span class="glyphicon glyphicon-tasks"></span>',
                  ['/panel-with-users/update', 'id' => $model->id],
                  [
                    'title' => Yii::t('backend', 'User mapping'),
                    'data-pjax' => 0,
                  ]);
                },
              ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
