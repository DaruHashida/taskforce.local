<?php

namespace frontend\models;

use frontend\models\Users;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class SecuritySettings extends ActiveRecord
{
    public $old_password;
    public $password_repeat;
    public $new_password;

    public function rules()
    {
        $user = Yii::$app->getUser()->getIdentity();
        return[
            [['new_password','old_password'],'required'],
            ['new_password', 'match', 'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*.])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*.]{6,}/',
                'message' => 'Пароль должен состоять не менее чем из 6-ти символов, содержать заглавную букву, знак препинания и цифру. 
                Мы хотим, чтобы Вы были в безопасности:)'],
            ['password_repeat', 'compare', 'compareAttribute' => 'new_password', 'operator' => '==', 'message' => 'Пароли не совпадают'],
            ['old_password','validateF']
        ];
    }
    public function resetPass()
    {
        $user_id = Yii::$app->user->getId();
        $user = Users::findOne($user_id);
        if (Yii::$app->security->validatePassword($this->old_password, $user->password)) {
            $user->password = Yii::$app->security->generatePasswordHash($this->new_password);
            return $user->save(false);
        }
    }
    public function validateF($attribute)
    {
        $user_id = Yii::$app->user->getId();
        $user = Users::findOne($user_id);
        if (!$user->validatePassword($this->old_password)) {
            $this->addError($attribute, 'Неправильный пароль');
        }
    }
}
