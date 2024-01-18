<?php

namespace frontend\models;

use Yii;
use frontend\models\Users;

/**
 * This is the model class for table "auth".
 *
 * @property int|null $source
 * @property int|null $source_id
 * @property int|null $name_of_API
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source', 'source_id', 'name_of_API'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'source' => 'Source',
            'source_id' => 'Source ID',
            'name_of_API' => 'Name Of Api',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AuthQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthQuery(get_called_class());
    }

    public function myUser()
    {
        Users::findOne($this->user);
    }
}
