<?php


namespace frontend\controllers;
use frontend\models\Auth;
use frontend\models\Users;
use frontend\models\Cities;
use frontend\models\LoginForm;
use yii\widgets\ActiveForm;
use yii\authclient\BaseClient;
use Yii;

class FormController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'vk' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionSignup()
    {
        $user = new Users();
        $cities = Cities::find()->orderBy('﻿name')->all();
        if (Yii::$app->request->getIsPost())
        {
            $user->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($user);
            }

            if ($user->validate())
            {
                $user->password = Yii::$app->security->generatePasswordHash($user->password);
                $user->save(false);
                $this->goHome();
            }
        }
        return $this->render('signup',['model'=>$user,'cities'=>$cities]);
    }
    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if (\Yii::$app->request->getIsPost()) {
            $loginForm->load(\Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($loginForm);
            }

            if ($loginForm->validate()) {
                \Yii::$app->user->login($loginForm->getUser());
                return $this->goHome();
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function onAuthSuccess(BaseClient $client)
    {
        $userdata = $client->getUserAttributes();
        $zahod = Auth::find()->where(['source'=>$client->getId(), 'source_id'=>$userdata['id']])->one();
        if ($zahod)
        {
            Yii::$app->user->login(Users::findOne($zahod->user));
        }
        else
        {
            if (isset($userdata['email']) && Users::find()->where(['email'=>$userdata['email']])->exists())
            {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Пользователь с такой электронной почтой уже есть. Пожалуйста, войдите под своим паролем!')
                ]);
            }
            else
            {
                if (isset($userdata['city']['title']))
                {
                    $city = Cities::find()->where(['﻿name'=>$userdata['city']['title']])->one();
                }

                $password = Yii::$app->security->generateRandomString(6);
                $user = new Users([
                    'user_name' => $userdata['first_name'],
                    'user_city' => $city->id??NULL,
                    'user_email'=>$userdata['email']??NULL,
                    'user_img'=>$userdata['photo']??NULL,
                    'password'=>Yii::$app->security->generatePasswordHash($password)
                ]);
                if ($user->save(false))
                {
                    $auth = new Auth ([
                        'source'=>$client->getId(),
                        'source_id'=>$userdata['id'],
                        'user'=>$user->id,
                        'name_of_API'=>'VK'
                    ]);
                    $auth->save(false);
                    Yii::$app->user->login($user);
                }

            }
        }
        $this->goHome();
        if (isset($password)) {
            Yii::$app->session->setFlash('success', "Ваш пароль:   $password   .");
        }
    }
}