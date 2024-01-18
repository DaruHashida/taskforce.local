<?php


namespace frontend\controllers;
use frontend\models\Categories;
use frontend\models\Settings;
use frontend\models\SecuritySettings;
use Yii;
use frontend\models\Users;
use frontend\models\Cities;
use frontend\models\LoginForm;
use yii\widgets\ActiveForm;
use yii\authclient\BaseClient;
use yii\web\UploadedFile;
class SettingsController extends SecuredController
{

public function actionIndex()
{   $user = Yii::$app->getUser()->getIdentity();
    $picture_addr = $user->user_img;
    $categories = Categories::find()->all();
    $settings = new Settings();
    if (Yii::$app->request->getIsPost())
    {   $settings->load(Yii::$app->request->post());
        if (Yii::$app->request->isAjax)
        {
            Yii::$app->response->format=Response::FORMAT_JSON;
            return ActiveForm::validate($settings);
        }
        if($settings->validate())
        {
            $settings->imageFile = UploadedFile::getInstance($settings, 'imageFile');
            $settings->change();
            $this->goHome();
        }
    }
    return $this->render('index',['model'=>$settings,'picture_addr'=>$picture_addr,'categories'=>$categories]);
}

public function actionSecuritysettings()
{
    $settings = new SecuritySettings();
    if (Yii::$app->request->getIsPost())
    {
        $settings->load(Yii::$app->request->post());
        if (Yii::$app->request->isAjax)
        {
            Yii::$app->response->format=Response::FORMAT_JSON;
            return ActiveForm::validate($settings);
        }
        if($settings->validate())
        {
            $settings->resetPass();
            $this->goHome();
        }
    }
    return $this->render('securitysettings',['model'=>$settings]);
}
}