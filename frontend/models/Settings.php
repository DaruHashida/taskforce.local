<?php

namespace frontend\models;

use frontend\models\Users;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use Yii;

class Settings extends ActiveRecord
{
    public $specialities;
    public $email;
    public $birthday;
    public $telegram;
    public $user_name;
    public $imageFile;
    public $description;
    public $phone;
    public $img;
    public function rules()
    {
        $user = Yii::$app->getUser()->getIdentity();
        return[
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/',
                'message' => 'Номер телефона должен состоять из 11 цифр'],
            [['imageFile'], 'file', 'maxSize' => 1024 * 1024, 'skipOnEmpty' => true, 'message' => 'Ваше изображение не должно быть больше 1Мбайта!'],
            [['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png, gif', 'message' => 'Ваше изображение должно иметь либо формат jpg, либо jpeg, либо png, либо gif!'],
            ['email','email'],
            ['birthday', 'date', 'format' => 'php:Y-m-d'],
            ['telegram', 'match', 'pattern' => '/^@[a-zA-Z0-9][a-zA-Z0-9_]{3,29}$/', 'message' => 'Ник в телеграмме должен начинаться со знака @'],
            ['description', 'string', 'max' => 750],
            ['user_name', 'string', 'min' => 3, 'max' => 30],
            ['img','string'],
            ['specialities', 'default', 'value' => null],
            ];
    }

    public function upload()
    {
        $user = Yii::$app->getUser()->getIdentity();
        $id = $user->user_id;

        if ($this->validate()) {
            $path = '\img\\' . $id . '\\' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $full_path_to_save = Yii::$app->basePath . '\web' . $path;
            if (!is_dir(Yii::$app->basePath . '\web\img\\' . $id)) {
                mkdir(Yii::$app->basePath . '\web\img\\' . $id, 0777, true);
            }
            $this->imageFile->saveAs($full_path_to_save);
            return $path;
        } else {
            return false;
        }
    }

    public function change()
    {
        $user_id = Yii::$app->user->getId();
        $user = Users::findOne($user_id);
        if ($this->user_name) {
            $user->user_name = $this->user_name;
        }
        if ($this->phone) {
            $user->phonenumber = $this->phone;
        }
        if ($this->specialities) {
            $user->specialization = implode(' ', $this->specialities);
        }
        if ($this->email) {
            $user->user_email = $this->email;
        }
        if ($this->imageFile) {
            $user->user_img = $this->upload();
        }
        if ($this->birthday) {
            $user->birth_date = $this->birthday;
        }
        if ($this->telegram) {
            $user->telegram = $this->telegram;
        }
        if ($this->description) {
            $user->user_description = $this->description;
        }
        return $user->save(false);
    }
}
