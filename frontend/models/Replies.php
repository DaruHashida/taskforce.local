<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property int $user_id
 * @property string $dt_add
 * @property string $description
 * @property int $task_id
 * @property int|null $is_approved
 * @property int|null $price
 */
class Replies extends \yii\db\ActiveRecord
{   protected static $_instance;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'replies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'description', 'task_id', 'price'], 'required'],
            [['user_id', 'task_id', 'is_approved', 'price'], 'integer'],
            [['dt_add'], 'safe'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'dt_add' => 'Dt Add',
            'description' => 'Description',
            'task_id' => 'Task ID',
            'is_approved' => 'Is Approved',
            'price' => 'Price',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RepliesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RepliesQuery(get_called_class());
    }

    public static function getInstance()
    {
        if (self::$_instance === null)
        {
            return new self;
        }
        return self::$_instance;
    }
}
