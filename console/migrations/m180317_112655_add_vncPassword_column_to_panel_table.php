<?php

use yii\db\Migration;

/**
 * Handles adding vncPassword to table `panel`.
 */
class m180317_112655_add_vncPassword_column_to_panel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('panel', 'vncPassword', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('panel', 'vncPassword');
    }
}
