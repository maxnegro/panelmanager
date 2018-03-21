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

    /**
     * Display a certificate in human readable form
     *
     * @return mixed
     */
    public function actionView($id) {
      $ca = \Yii::$app->opensslca;
      $cert = $ca->getCert($id);
      if (!$cert) {
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
      }
      return $this->render('view',[
        'cert' => $cert,
        'certInfo' => $ca->getCertInfo($ca->getCertFile($id)),
      ]);
    }
}
