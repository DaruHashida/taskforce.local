<?php

use src\logic\DataToSQLConverter;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m240117_080304_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $conv = new DataToSQLConverter('C:\My_site\taskforce.local\frontend\web\data','categories');
        $this->execute($conv->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
