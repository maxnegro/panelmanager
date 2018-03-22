<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PanelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'VPN Certificates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ca-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php Pjax::begin(['clientOptions' => ['showNoty' => false]]); ?>

    <p>
        <?= Html::a(Yii::t('backend', 'New Certificate'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model) {
          if ($model['serialNumber'] == 2) {
            return ['class'=>'danger'];
          }
        },
        'columns' => [
            'serialNumber',
            [
              'attribute' => 'organization',
              'label' => Yii::t('backend', 'Organization'),
              'value' => function($model) { return $model['subject']['O']; },
            ],
            [
              'attribute' => 'commonName',
              'label' => Yii::t('backend', 'Common Name'),
              'value' => function($model) { return $model['subject']['CN']; },
            ],
            [
              'attribute' => 'validTo_time_t',
              'label' => Yii::t('backend', 'Valid Until'),
              'format' => 'datetime'
            ],
            [
              'attribute' => 'isValid',
              'label' => Yii::t('backend', 'Valid Certificate'),
              'value' => function($model) {
                if ($model['serialNumber'] == 2) {
                  return '<span class="glyphicon glyphicon-remove"></span>';
                } else {
                  return '<span class="glyphicon glyphicon-ok"></span>';
                }
              },
              'format' => 'raw',
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'visibleButtons' => [
                'view' => function ($model) { return $model['serialNumber'] != 2; },
                'revoke' => function ($model) { return $model['serialNumber'] != 2; },
                'download' => function ($model) { return $model['serialNumber'] != 2; },
              ],
              'template' => '{view} {revoke} {download}',
              'buttons' => [
                'revoke' => function($url, $model) {
                  return Html::a(
                    '<span class="glyphicon glyphicon-remove"></span>',
                    ['revoke', 'id' => $model['serialNumber']],
                    [
                      'title' => Yii::t('backend', 'Revoke'),
                      'data-pjax' => 0,
                    ]
                  );
                },
                'download' => function($url, $model) {
                  return Html::a(
                    '<span class="glyphicon glyphicon-download-alt"></span>',
                    ['download', 'id' => $model['serialNumber']],
                    [
                      'title' => Yii::t('backend', 'Download'),
                      'data-pjax' => 0,
                    ]
                  );
                },
              ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
