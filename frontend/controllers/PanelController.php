<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Panel;
use common\models\UserPanel;
use common\models\Websocket;
use common\models\Webproxy;
use yii\base\Security;


/**
 * Class SiteController.
 */
class PanelController extends Controller
{
    public $layout = 'custom';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Sets up and launches noVNC on required panel
     */
    public function actionView($id) {
      if (Yii::$app->user->isGuest) {
        throw new \yii\web\HttpException(418, Yii::t('frontend', 'I\'m a teapot.'));
      }
      if (! UserPanel::find()->where(['user_id' => Yii::$app->user->ID, 'panel_id' => $id])->exists()) {
        throw new \yii\web\HttpException(403, Yii::t('frontend', 'You don\'t exist. Go away.'));
      }
      $panel = $this->findPanel($id);
      $security = new Security();
      $token = $security->generateRandomString();
      if ($panel->type === 'vnc') {
        Websocket::deleteAll(['<', 'validUntil', time()]);
        $socket = new Websocket();
        $socket->token = $token;
        $socket->ip = $panel->ipAddress;
        $socket->port = $panel->port;
        $socket->validUntil = time()+30; // token is valid for 30 seconds after creation
        $socket->save();

        return $this->render('view-no-vnc', [
          'panelName' => $panel->userName,
          'host' => Yii::getAlias('@websocketProxyHost'),
          'port' => Yii::getAlias('@websocketProxyPort'),
          'password' => $panel->vncPassword,
          'path' => Yii::getAlias('@websocketProxyPath') . $socket->token,
        ]);
      } elseif($panel->type == 'http') {
        Webproxy::deleteAll(['<', 'validUntil', time()]);
        $webproxy = new Webproxy();
        $webproxy->token = $token;
        $webproxy->ip = $panel->ipAddress;
        $webproxy->port = $panel->port;
        $webproxy->validUntil = time()+300; // token is valid for 30 seconds after creation
                                            // Validity is extended on access by access control logic in Nginx
        $webproxy->save();

        return $this->render('view-http', [
          'scheme' => Yii::getAlias('@httpProxyPort') == 443 ? 'https' : 'http',
          'host' => Yii::getAlias('@httpProxyHost'),
          'port' => Yii::getAlias('@httpProxyPort'),
          'path' => Yii::getAlias('@httpProxyPath') . '/' . $webproxy->token . '/',
        ]);
      } else {
        throw new \yii\web\HttpException(500, 'This should not happen. You have seen nothing.');
      }
    }

    /**
     * Finds the Panel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Panel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPanel($id)
    {
        if (($model = Panel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
