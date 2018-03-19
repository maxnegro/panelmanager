<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
// use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
// use backend\models\search\UserSearch;
// use backend\models\UserForm;
use common\models\PanelWithUsers;
use common\models\User;

/**
 * Class UserController.
 */
class PanelWithUsersController extends Controller
{
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      $model = $this->findModel($id);
      $model->loadUsers();

      if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
          $model->saveUsers();
          return $this->redirect(['/panel/index']);
        }
      }

      return $this->render('update', [
        'model' => $model,
        'users' => User::getAvailableUsers(false),
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
        if (($model = PanelWithUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
