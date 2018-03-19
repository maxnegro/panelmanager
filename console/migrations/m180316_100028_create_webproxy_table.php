<?php

use yii\db\Migration;

/**
 * Handles the creation of table `webproxy`.
 */
class m180316_100028_create_webproxy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('webproxy', [
          'token' => $this->string(32)->notNull(),
          'ip' => $this->string()->notNull(),
          'port' => $this->integer()->defaultValue(80),
          'validUntil' => $this->integer(11),
        ]);
        $this->addPrimaryKey('PK_webproxy_token', 'webproxy', 'token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('webproxy');
    }
}
