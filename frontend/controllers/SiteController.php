<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use yii\data\ActiveDataProvider;
use common\models\Panel;
use common\models\UserPanel;
use common\models\Websocket;
use common\models\Webproxy;
use yii\base\Security;


/**
 * Class SiteController.
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => '@storage/tmp',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
      if (Yii::$app->user->isGuest) {
        return $this->render('index');
      } else {
        $dp = new ActiveDataProvider([
          'query' => Panel::find()->joinWith('userPanels', false)->where(['user_panel.user_id' => Yii::$app->user->ID]),
          'pagination' => [
            'pageSize' => 20,
          ],
        ]);

        $dp->sort = [
            'defaultOrder' => ['site' => SORT_ASC, 'userName' => SORT_ASC],
        ];

        return $this->render('index-logged-in', [
          'dataprovider' => $dp,
        ]);
      }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'There was an error sending your message.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', ['model' => $model]);
        }
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
        $socket->validUntil = time()+300; // token is valid for 300 seconds after creation
        $socket->save();

        return $this->render('view-no-vnc', [
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
        $webproxy->validUntil = time()+300;
        $webproxy->save();

        return $this->render('view-http', [
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
