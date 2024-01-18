<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m231005_160441_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'user_registration_date'=>$this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'user_name'=>$this->string(),
            'user_img'=>$this->string(),
            'user_email'=>$this->string(),
            'birth_date'=>$this->date(),
            'user_description'=>$this->text(),
            'telegram'=>$this->string(),
            'role'=>$this->boolean(),
            'reputation'=>$this->integer(),
            'own_tasks'=>$this->string(),
            'performing_tasks'=>$this->string(),
            'specialization'=>$this->string(),
            'bio'=>$this->string(),
            'user_city'=>$this->string(),
            'responces_count'=>$this->integer(),
            'phonenumber'=>$this->string(),
            'password'=>$this->string(),
            'failed_tasks'=>$this->integer(),
            'opinions'=>$this->integer(),
            'done_tasks'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
