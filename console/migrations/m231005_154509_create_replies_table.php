<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%replies}}`.
 */
class m231005_154509_create_replies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%replies}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'dt_add' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'description'=>$this->text(),
            'task_id'=>$this->integer(),
            'is_approved'=>$this->tinyInteger(),
            'price'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%replies}}');
    }
}
