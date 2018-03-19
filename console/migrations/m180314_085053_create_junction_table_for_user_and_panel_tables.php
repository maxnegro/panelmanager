<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_panel`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `panel`
 */
class m180314_085053_create_junction_table_for_user_and_panel_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_panel', [
            'user_id' => $this->integer(),
            'panel_id' => $this->integer(),
            'PRIMARY KEY(user_id, panel_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_panel-user_id',
            'user_panel',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_panel-user_id',
            'user_panel',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `panel_id`
        $this->createIndex(
            'idx-user_panel-panel_id',
            'user_panel',
            'panel_id'
        );

        // add foreign key for table `panel`
        $this->addForeignKey(
            'fk-user_panel-panel_id',
            'user_panel',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_panel-user_id',
            'user_panel'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_panel-user_id',
            'user_panel'
        );

        // drops foreign key for table `panel`
        $this->dropForeignKey(
            'fk-user_panel-panel_id',
            'user_panel'
        );

        // drops index for column `panel_id`
        $this->dropIndex(
            'idx-user_panel-panel_id',
            'user_panel'
        );

        $this->dropTable('user_panel');
    }
}
