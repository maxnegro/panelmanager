<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
// use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
// use backend\models\search\UserSearch;
// use backend\models\UserForm;
use common\models\UserWithPanels;
use common\models\Panel;

/**
 * Class UserController.
 */
class UserWithPanelsController extends Controller
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
        // $searchModel = new UserSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //
        // $dataProvider->sort = [
        //     'defaultOrder' => ['created_at' => SORT_DESC],
        // ];
        //
        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    // public function actionCreate()
    // {
    //   $model = new UserWithPanels();
    //   $model->setScenario('create');
    //
    //   if ($model->load(Yii::$app->request->post())) {
    //     if ($model->save()) {
    //       $model->savePanels();
    //       return $this->redirect(['index']);
    //     }
    //   }
    //
    //   return $this->render('create', [
    //     'model' => $model,
    //     'panels' => Panel::getAvailablePanels(),
    //   ]);
    // }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      $model = UserWithPanels::findOne($id);
      $model->loadPanels();

      if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
          $model->savePanels();
          return $this->redirect(['/user/index']);
        }
      }

      return $this->render('update', [
        'model' => $model,
        'panels' => Panel::getAvailablePanels(false),
      ]);

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     if ($id == Yii::$app->user->id) {
    //         Yii::$app->session->setFlash('error', Yii::t('backend', 'You can not remove your own account.'));
    //     } else {
    //         // remove avatar
    //         $avatar = UserProfile::findOne($id)->avatar_path;
    //         if ($avatar) {
    //             unlink(Yii::getAlias('@storage/avatars/' . $avatar));
    //         }
    //         Yii::$app->authManager->revokeAll($id);
    //         $this->findModel($id)->delete();
    //
    //         Yii::$app->session->setFlash('success', Yii::t('backend', 'User has been deleted.'));
    //     }
    //
    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
