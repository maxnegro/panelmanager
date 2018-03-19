<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "websockets".
 *
 * @property string $token
 * @property string $ip
 * @property int $port
 * @property string $validUntil
 */
class Websocket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'websocket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'ip'], 'required'],
            [['port'], 'integer'],
            [['validUntil'], 'integer'],
            [['token', 'ip'], 'string', 'max' => 255],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'ip' => 'Ip',
            'port' => 'Port',
            'validUntil' => 'Valid Until',
        ];
    }
}
