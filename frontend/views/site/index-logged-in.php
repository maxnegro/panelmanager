<?php
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = Yii::$app->name;
use frontend\assets\NoVncAsset;
$asset = NoVncAsset::register($this);
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Lista pannelli</h1>
    </div>
</div>
<?php
echo GridView::widget([
  'dataProvider' => $dataprovider,
  'columns' => [
    'site',
    'userName',
    'type',
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{view}',
      'header' => Yii::t('frontend', 'Show Panel'),
      'buttons' => [
        'view' => function($url, $model) {
          return Html::a('<span class="glyphicon glyphicon-fullscreen"></span>', $url, ['title'=>Yii::t('frontend', 'Open panel in new window'), 'target'=>'_new']);
        }
      ],
    ],
  ]
]);
?>
