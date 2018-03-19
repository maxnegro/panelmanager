<?php

use yii\db\Migration;

/**
 * Handles the creation of table `panel`.
 */
class m180301_165913_create_panel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('panel', [
            'id' => $this->primaryKey(),
            'adminName' => $this->string(255)->notNull(),
            'userName' => $this->string(255)->notNull(),
            'site' => $this->string(255),
            'type' => $this->string(10)->defaultValue('vnc'),
            'ipAddress' => $this->string(80),
            'port' => $this->integer(11)
        ]);

        // Tabella di appoggio per relazione n:m tra pannelli e utenti
        $this->createTable('user_to_panel', [
          'user_id' => $this->integer(11),
          'panel_id' => $this->integer(11)
        ]);

        // Indice e FK per user_id
        $this->createIndex(
          'idx-user_to_panel-user_id',
          'user_to_panel',
          'user_id'
        );
        $this->addForeignKey(
          'fk-user_to_panel-user_id',
          'user_to_panel',
          'user_id',
          'user',
          'id',
          'CASCADE'
        );

        //  Indice e FK per panel_id
        $this->createIndex(
          'idx-user_to_panel-panel_id',
          'user_to_panel',
          'panel_id'
        );
        $this->addForeignKey(
          'fk-user_to_panel-panel_id',
          'user_to_panel',
          'panel_id',
          'panel',
          'id',
          'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_to_panel-panel_id', 'user_to_panel');
        $this->dropIndex('idx-user_to_panel-panel_id', 'user_to_panel');
        $this->dropForeignKey('fk-user_to_panel-user_id', 'user_to_panel');
        $this->dropForeignKey('idx-user_to_panel-user_id', 'user_to_panel');
        $this->dropTable('user_to_panel');
        $this->dropTable('panel');
    }
}
