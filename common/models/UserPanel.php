<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_panel".
 *
 * @property int $user_id
 * @property int $panel_id
 *
 * @property Panel $panel
 * @property User $user
 */
class UserPanel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_panel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'panel_id'], 'required'],
            [['user_id', 'panel_id'], 'integer'],
            [['user_id', 'panel_id'], 'unique', 'targetAttribute' => ['user_id', 'panel_id']],
            [['panel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Panel::className(), 'targetAttribute' => ['panel_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'panel_id' => 'Panel ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPanel()
    {
        return $this->hasOne(Panel::className(), ['id' => 'panel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
