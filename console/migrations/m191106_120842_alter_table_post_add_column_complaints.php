<?php

use yii\db\Migration;

/**
 * Class m191106_120842_alter_table_post_add_column_complaints
 */
class m191106_120842_alter_table_post_add_column_complaints extends Migration
{
    public function up()
    {
        $this->addColumn('{{%post}}', 'complaints', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%post}}', 'complaints');
    }
}
