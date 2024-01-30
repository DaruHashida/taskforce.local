<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Users;
use frontend\models\Tasks;
use frontend\models\Categories;

class MytasksController extends SecuredController
{
    public function getSearchQuery()
    {
        $task = new Tasks();
        $task->load(Yii::$app->request->post());

        $taskQuery = $task->getSearchQuery();
        $taskQuery = $taskQuery->andWhere(['task_host' => Yii::$app->user->getId()]);
        $taskQuery = $taskQuery->orWhere(['task_performer' => Yii::$app->user->getId()]);

        return $taskQuery;
    }

    public function actionIndex()
    {
        $models = $this->getSearchQuery()->all();
        $categories = Categories::find()->asArray()->all();
        return $this->render(
            'index',
            ['models' => $models,
            'categories' => $categories]
        );
    }

    public function actionIndexdone()
    {
        $models = $this->getSearchQuery()->andWhere(['task_status' => 'STATUS_DONE'])->all();

        $categories = Categories::find()->asArray()->all();

        return $this->render(
            'index',
            ['models' => $models,
            'categories' => $categories]
        );
    }
    public function actionIndexprocessing()
    {
        $models = $this->getSearchQuery()->andWhere(['task_status' => 'STATUS_PROCESSING'])->all();

        $categories = Categories::find()->asArray()->all();

        return $this->render(
            'index',
            ['models' => $models,
            'categories' => $categories]
        );
    }

    public function actionIndexnew()
    {
        $models = $this->getSearchQuery()->andWhere(['task_status' => 'STATUS_NEW'])->all();

        $categories = Categories::find()->asArray()->all();

        return $this->render(
            'index',
            ['models' => $models,
            'categories' => $categories]
        );
    }
}
