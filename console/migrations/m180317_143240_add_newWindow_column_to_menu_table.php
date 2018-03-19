<?php

use yii\db\Migration;

/**
 * Handles adding newWindow to table `menu`.
 */
class m180317_143240_add_newWindow_column_to_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%navbar_menu}}', 'new_window', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%navbar_menu}}', 'new_window');
    }
}
