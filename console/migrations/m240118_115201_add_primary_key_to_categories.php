<?php

use yii\db\Migration;

/**
 * Class m240118_115201_add_primary_key_to_categories
 */
class m240118_115201_add_primary_key_to_categories extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%categories}}', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories}}', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240118_115201_add_primary_key_to_categories cannot be reverted.\n";

        return false;
    }
    */
}
