<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
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
          return Html::a(
            '<span class="glyphicon glyphicon-fullscreen"></span>',
            Url::toRoute(['panel/view', 'id'=>$model->id]),
            [
              'title'=>Yii::t('frontend', 'Open panel in new window'),
              'target'=>'_new',
              'onclick' => sprintf('window.open(\'%s%s\',\'panel\',\'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,width=800,height=600\'); return false;', Yii::getAlias('@frontendUrl'), Url::to(['panel/view', 'id'=>$model->id])),
            ]);
        }
      ],
    ],
  ]
]);
?>
