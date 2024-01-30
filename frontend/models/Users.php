<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * Class Users
 * @package frontend\models
 */
class Users extends BaseUser implements yii\web\IdentityInterface
{
    public $password_repeat;
    public $old_password;
    public $new_password;
    public $new_password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
    public function rules()
    {
    return [
    [['user_registration_date', 'birth_date'], 'safe'],
    [['responces_count'], 'integer'],
    [['user_name', 'user_img', 'user_email', 'user_description', 'telegram', 'role', 'reputation', 'own_tasks', 'performing_tasks', 'specialization', 'bio', 'user_city', 'password'], 'string', 'max' => 50],
    [['phonenumber'], 'string', 'max' => 16],
    [['user_email'], 'unique'],
    ];
    }  */


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_registration_date' => 'User Registration Date',
            'user_name' => 'User Name',
            'user_img' => 'User Img',
            'user_email' => 'User Email',
            'birth_date' => 'Birth Date',
            'user_description' => 'User Description',
            'telegram' => 'Telegram',
            'role' => 'Я буду выполнять заказы',
            'reputation' => 'Reputation',
            'own_tasks' => 'Own Tasks',
            'performing_tasks' => 'Performing Tasks',
            'specialization' => 'Specialization',
            'bio' => 'Bio',
            'user_city' => 'User City',
            'responces_count' => 'Responces Count',
            'phonenumber' => 'Phonenumber',
            'password' => 'Password',
            'old_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'password_repeat' => 'Повтор пароля',
            'new_password_repeat' => 'Повтор пароля',
            'done_tasks' => 'Выполненные задания'
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @param $username
     * @return mixed
     */
    public static function findByUserEmail(string $user_email)
    {
        return self::findOne(['user_email' => $user_email]);
    }
    /**
     * @return array
     */
    public function rules()
    {
        /*return [
            [['user_registration_date', 'birth_date'], 'safe'],
            [['responces_count'], 'integer'],
            [['user_name', 'user_img', 'user_email', 'user_description', 'telegram', 'role', 'reputation', 'own_tasks', 'performing_tasks', 'specialization', 'bio', 'user_city', 'phonenumber'], 'string', 'max' => 50],
            [['user_email'], 'unique'],
        ];*/
        return [
            [['user_name','user_email','user_city','password','password_repeat'],'required'/*,'on'=>self::SCENARIO_DEFAULT*/],
            ['user_email','email'],
            ['user_email','unique'/*,'on'=>self::SCENARIO_DEFAULT*/],
            ['phonenumber', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/',
                'message' => 'Номер телефона должен состоять из 11 цифр'],
            ['password', 'match', 'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*.])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*.]{6,}/',
                'message' => 'Пароль должен состоять не менее чем из 6-ти символов, содержать заглавную букву, знак препинания и цифру. 
                Мы хотим, чтобы Вы были в безопасности:)'],
            ['password','compare',/*,'on'=>self::SCENARIO_DEFAULT*/],
            ['role', 'default', 'value' => 0],
            ['done_tasks','integer']

        ];
    }

    /**
     * @param $id
     * @return Users|null
     */
    public function getUser(int $id)
    {
        return self::findOne($id);
    }
    public function getUserByName($name)
    {
        return self::findOne(['user_name' => $name]);
    }

    /**
     * @return int
     */
    public function getAge()
    {
        if ($this->birth_date) {
            $secs_in_year = 31536000;
            $birthday = strtotime($this->birth_date);
            $now_time = time();
            $diff = $now_time - $birthday;
            return intdiv($diff, $secs_in_year);
        }
    }

    /**
     * @return false|string
     */
    public function getDate()
    {
        $date = date_create($this->user_registration_date);
        return date_format($date, "Y F d");
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}
