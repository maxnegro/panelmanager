<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\UserPanel;


/**
 * This is the model class for table "panel".
 *
 * @property int $id
 * @property string $adminName
 * @property string $userName
 * @property string $site
 * @property string $type
 * @property string $ipAddress
 * @property int $port
 *
 * @property UserPanel[] $userToPanels
 */
class Panel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'panel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adminName', 'userName', 'type', 'ipAddress', 'port'], 'required'],
            [['adminName', 'userName', 'site', 'vncPassword'], 'string', 'max' => 255],
            [['type'], 'in', 'range' => ['vnc','http']],
            [['ipAddress'], 'ip'],
            [['port'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adminName' => Yii::t('common', 'Name (admin view)'),
            'userName' => Yii::t('common', 'Name'),
            'site' => Yii::t('common', 'Site'),
            'type' => Yii::t('common', 'Type'),
            'ipAddress' => Yii::t('common', 'Ip Address'),
            'port' => Yii::t('common', 'Port'),
            'vncPassword' => Yii::t('common', 'VNC Password'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPanels()
    {
        return $this->hasMany(UserPanel::className(), ['panel_id' => 'id']);
    }

    public function getuserNameWithSite() {
      return (!empty($this->site) ? $this->site . ' - ' : '') . $this->userName;
    }
    public function getadminNameWithSite() {
      return (!empty($this->site) ? $this->site . ' - ' : '') . $this->adminName;
    }

    /**
     * Utility function, useful in forms
     * Get all the available panels
     * @return array available panels id => desc
     */
    public static function getAvailablePanels($isFrontend = true) {
      $nameField = $isFrontend ? 'userName' : 'adminName';
      $panels = self::find()->orderBy(['site' => SORT_DESC, $nameField => SORT_DESC])->all();
      $items = ArrayHelper::map($panels, 'id', $nameField . 'WithSite');
      return $items;
    }
}
