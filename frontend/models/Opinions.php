<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "opinions".
 *
 * @property int $id
 * @property string $description
 * @property int $rate
 * @property int $user_id
 * @property int $responsor_id
 */
class Opinions extends \yii\db\ActiveRecord
{   protected static $_instance;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'opinions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rate', 'user_id', 'responsor_id'], 'integer'],
            [['description'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'rate' => 'Rate',
            'user_id' => 'User ID',
            'responsor_id' => 'Responsor ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OpinionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpinionsQuery(get_called_class());
    }

    /**
     * @return Opinions
     */
    public static function getInstance()
    {
        if (self::$_instance === null)
        {
            return new self;
        }
        return self::$_instance;
    }
}
