<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "webproxy".
 *
 * @property string $token
 * @property string $ip
 * @property int $port
 * @property int $validUntil
 */
class Webproxy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webproxy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'ip'], 'required'],
            [['port', 'validUntil'], 'integer'],
            [['token'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 255],
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
