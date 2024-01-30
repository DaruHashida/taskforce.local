<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cities".
 *
 * @property string|null $city
 * @property float|null $lat
 * @property float|null $long
 */
class Cities extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat', 'long'], 'number'],
            [['city'], 'string', 'max' => 27],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city' => 'City',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }
}
