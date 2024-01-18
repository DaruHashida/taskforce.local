<?php

use yii\db\Migration;
use src\logic\DataToSQLConverter;

/**
 * Handles the creation of table `{{%cities}}`.
 */
class m240117_080228_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   $conv = new DataToSQLConverter('C:\My_site\taskforce.local\frontend\web\data','cities');
        $this->execute($conv->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cities}}');
    }
}
