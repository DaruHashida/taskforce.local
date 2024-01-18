<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m231005_155354_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'task_creation_date'=>$this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'task_title'=>$this->string(),
            'task_description'=>$this->text(),
            'task_host'=>$this->integer(),
            'task_performer'=>$this->integer(),
            'task_expire_date'=>$this->date(),
            'task_status'=>$this->string(),
            'task_coordinates'=>$this->string(),
            'task_price'=>$this->integer(),
            'task_category'=>$this->string(),
            'task_city'=>$this->string(),
            'task_file'=>$this->string(),
            'task_file_name'=>$this->string(),
            'task_file_size'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');
    }
}
