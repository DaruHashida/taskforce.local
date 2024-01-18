<?php


namespace frontend\controllers;

use frontend\models\Categories;
use frontend\models\Cities;
use frontend\models\Tasks;
use frontend\models\Replies;
use frontend\models\TasksQuery;
use src\logic\CancelAction;
use src\logic\ReactAction;
use src\logic\FinishAction;
use src\logic\DenyAction;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Yii;

class TasksController extends SecuredController
{
    public function actionIndex()
    {
        $task = new Tasks();
        $task->load(Yii::$app->request->post());

        $taskQuery = $task->getSearchQuery();
        $categories = Categories::find()->asArray()->all();

        $models = $taskQuery->andWhere('task_host !='.Yii::$app->user->getId())->all();

        return $this->render('index',
            ['models'=> $models,
            'task'=>$task,
            'categories'=>$categories]);
    }

    public function actionIndexmy ()
    {
        $task = new Tasks();
        $task->load(Yii::$app->request->post());

        $taskQuery = $task->getSearchQuery();
        $models = $taskQuery->andWhere(['task_host'=> Yii::$app->user->getId()])->all();
        $categories = Categories::find()->asArray()->all();

        return $this->render('index',
            ['models'=> $models,
                'task'=>$task,
                'categories'=>$categories]);
    }

    public function actionIndexnew ()
    {
        $task = new Tasks();
        $task->load(Yii::$app->request->post());

        $taskQuery = $task->getSearchQuery();
        $models = $taskQuery->andWhere(['task_status'=> 'STATUS_NEW'])->all();
        $categories = Categories::find()->asArray()->all();

        return $this->render('index',
            ['models'=> $models,
                'task'=>$task,
                'categories'=>$categories]);
    }

    public function actionView ($id)
    {   if(Tasks::find($id)->exists()) {
        $task = new Tasks();
        $taskQuery = $task->getTask($id);
        return $this->render('view',
            ['data' => $taskQuery,
                'task_host' => $taskQuery->getOwner(),
                'task_performer' => $taskQuery->getPerformer(),
                'task_replies' => $taskQuery->replies,
                'task_owner' => $taskQuery->getOwner()]);
        }
        else
        {
            $this->goHome();
        }
    }

    public function actionAdd()
    {
        $task = new Tasks();
        $cities = Cities::find()->orderBy('﻿name')->all();
        $categories = Categories::find()->orderBy('name')->all();
        if (Yii::$app->request->getIsPost())
        {
            $task->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($task);
            }

            if ($task->validate())
            {   $task->attach_file = UploadedFile::getInstance($task, 'attach_file');
                if ($task->attach_file)
                {
                    $task->upload();
                }
                $task->save(false);
                return $this->redirect('/tasks/view/'.$task->id);
            }
        }
        return $this->render('add',['model'=>$task,
                            'categories'=>$categories,
                            'cities'=>$cities]);
    }

    public function actionCancel ($id)
    {   $task= Tasks::findOne($id);
        if (CancelAction::getUserProperties(Yii::$app->getUser()->getIdentity()->user_id, $task))
        {
            $task->delete();
            $this->goHome();
        }
        else
        {$this->goHome();}
    }

}