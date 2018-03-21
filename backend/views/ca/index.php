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

    <!-- <?= var_dump($dataProvider); ?> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
              'value' => function($model) { return date('d/m/Y H:i:s', $model['validTo_time_t']); },
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{view} {revoke}',
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
              ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
