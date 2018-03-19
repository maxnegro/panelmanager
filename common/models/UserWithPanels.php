<?php

namespace common\models;

use Yii;
// use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
// use yii\web\IdentityInterface;
// use common\models\query\UserQuery;
use common\models\User;
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
* @property array $panel_ids IDs of permitted panels
*/

class UserWithPanels extends User
{
  public $panel_ids = [];

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
      return ArrayHelper::merge(parent::attributeLabels(), [
        'panel_ids' => Yii::t('common', 'Assigned panels'),
      ]);
  }

  public function rules() {
    return ArrayHelper::merge(parent::rules(), [
      // each panel_id must exist in panel table
      ['panel_ids', 'each', 'rule' => [
        'exist', 'targetClass' => Panel::className(), 'targetAttribute' => 'id',
      ]],
    ]);
  }

  /**
  * load user permitted panels
  */

  public function loadPanels() {
    $this->panel_ids = [];
    if (!empty($this->id)) {
      $rows = UserPanel::find()
      ->select(['panel_id'])
      ->where(['user_id' => $this->id])
      ->asArray()
      ->all();
      foreach ($rows as $row) {
        $this->panel_ids[] = $row['panel_id'];
      }
    }
  }

  /**
  * Save user's panels
  */
  public function savePanels() {
    /* clear panels for the user before saving */
    UserPanel::deleteAll(['user_id' => $this->id]);
    /* Be careful: $this->panel_ids may be empty */
    if (is_array($this->panel_ids)) {
      foreach ($this->panel_ids as $panel_id) {
        $up = new UserPanel();
        $up->user_id = $this->id;
        $up->panel_id = $panel_id;
        $up->save();
      }
    }
  }

}
