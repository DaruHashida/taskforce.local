<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%opinions}}`.
 */
class m231005_154234_create_opinions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%opinions}}', [
            'id' => $this->primaryKey(),
            'description'=>$this->string(),
            'rate'=>$this->integer(),
            'user_id'=>$this->integer(),
            'responsor_id'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%opinions}}');
    }
}
