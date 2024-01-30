<?php

namespace frontend\controllers;

use Yii;

class LandingController extends \yii\base\Controller
{
    public $layout = 'landing';
    function actionHello()
    {
        return $this->render('hello');
    }
}
