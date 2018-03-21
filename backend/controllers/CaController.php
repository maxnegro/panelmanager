<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class UserController.
 */
class CaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
      $ca = \Yii::$app->opensslca;

      // echo "Certificates Issued: \n";
      $certs = [];
      foreach (glob($ca->getCaDir() . "/certs/*") as $cert) {
        $certs[] = $ca->getCertInfo($cert);
          // echo "  " . basename($cert) . ": " . $ca->getCertInfo($cert)['name'] ."\n";
      }
      return $this->render('index', [
        'dataProvider' => new ArrayDataProvider([
          'allModels' => $certs,
          'sort' => [
            'attributes' => ['serialNumber', 'validTo_time_t'],
          ],
          'key' => 'serialNumber',
          'pagination' => [
            'pageSize' => 15,
          ],
        ]),
      ]);
    }

}
