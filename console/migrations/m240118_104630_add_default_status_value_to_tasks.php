<?php

use yii\db\Migration;

/**
 * Class m240118_104630_add_default_status_value_to_tasks
 */
class m240118_104630_add_default_status_value_to_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%tasks}}', 'task_status');
        $this->addColumn('{{%tasks}}', 'task_status', $this->string()->defaultValue('STATUS_NEW'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'task_status');
        $this->addColumn('{{%tasks}}', 'task_status', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240118_104630_add_default_status_value_to_tasks cannot be reverted.\n";

        return false;
    }
    */
}
