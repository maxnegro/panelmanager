<?php

use yii\db\Migration;

/**
 * Handles adding theme to table `user_profile`.
 */
class m181129_095528_add_theme_column_to_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_profile', 'theme', $this->string(80));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_profile', 'theme');
    }
}
