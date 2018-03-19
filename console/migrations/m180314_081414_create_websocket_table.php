<?php

use yii\db\Migration;

/**
 * Handles the creation of table `websockets`.
 */
class m180314_081414_create_websocket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('websocket', [
            'token' => $this->string()->notNull(),
            'ip' => $this->string()->notNull(),
            'port' => $this->integer()->defaultValue(5900),
            'validUntil' => $this->integer(11),
        ]);
        $this->addPrimaryKey('PK_websocket_cookie', 'websocket', 'token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('websocket');
    }
}
