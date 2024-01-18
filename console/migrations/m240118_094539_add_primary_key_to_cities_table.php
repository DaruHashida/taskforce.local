<?php

use yii\db\Migration;

/**
 * Class m240118_094539_add_primary_key_to_cities_table
 */
class m240118_094539_add_primary_key_to_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cities}}', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cities}}', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240118_094539_add_primary_key_to_cities_table cannot be reverted.\n";

        return false;
    }
    */
}
