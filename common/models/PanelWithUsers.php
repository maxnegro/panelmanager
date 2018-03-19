<?php

namespace common\models;

use Yii;
// use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
// use yii\web\IdentityInterface;
// use common\models\query\UserQuery;
use common\models\Panel;
use common\models\UserPanel;
// use common\models\User;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "UserWithPanels".
*
* @property integer $id
* @property string $username
* @property string $auth_key
* @property string $access_token
* @property string $password_hash
* @property string $email
* @property integer $status
* @property string $ip
* @property integer $created_at
* @property integer $updated_at
* @property integer $action_at
*
* @property array $user_ids IDs of permitted panels
*/

class PanelWithUsers extends Panel
{
  public $user_ids = [];

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
      return ArrayHelper::merge(parent::attributeLabels(), [
        'user_ids' => Yii::t('common', 'Assigned users'),
      ]);
  }

  public function rules() {
    return ArrayHelper::merge(parent::rules(), [
      // each panel_id must exist in panel table
      ['user_ids', 'each', 'rule' => [
        'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id',
      ]],
    ]);
  }

  /**
  * load user permitted panels
  */

  public function loadUsers() {
    $this->user_ids = [];
    if (!empty($this->id)) {
      $rows = UserPanel::find()
      ->select(['user_id'])
      ->where(['panel_id' => $this->id])
      ->asArray()
      ->all();
      foreach ($rows as $row) {
        $this->user_ids[] = $row['user_id'];
      }
    }
  }

  /**
  * Save user's panels
  */
  public function saveUsers() {
    /* clear panels for the user before saving */
    UserPanel::deleteAll(['panel_id' => $this->id]);
    /* Be careful: $this->user_ids may be empty */
    if (is_array($this->user_ids)) {
      foreach ($this->user_ids as $user_id) {
        $up = new UserPanel();
        $up->user_id = $user_id;
        $up->panel_id = $this->id;
        $up->save();
      }
    }
  }

}
