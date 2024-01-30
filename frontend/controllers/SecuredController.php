<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class SecuredController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
        'access' => [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@']
                ],
                    [
                    'allow' => false,
                    'roles' => ['?'],
                    'denyCallback' => function ($rule, $action) {
                        return $this->goHome();
                    }
                    ]
                ]
            ]
        ];
    }
}
