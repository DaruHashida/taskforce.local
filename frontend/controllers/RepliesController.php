<?php


namespace frontend\controllers;
use Yii;
use frontend\models\Replies;
use frontend\models\Tasks;
use frontend\models\Users;
use yii\web\Response;
use src\logic\DenyAction;
use yii\widgets\ActiveForm;
use frontend\models\Opinions;

class RepliesController extends SecuredController
{
    public function actionDeny($id)
    {
        $reply = new Replies();
        $task = Tasks::findOne($id);
        $user = Users::findOne(Yii::$app->getUser()->getIdentity()->user_id);
        if (DenyAction::getUserProperties($user->user_id, $task)) {
            $task->task_status = 'STATUS_FAILED';
            $user->failed_tasks += 1;
            $user->save(false);
        }
        $this->redirect(['/tasks/'.$id]);
    }
    public function actionResponse ()
    {   $reply = Replies::getInstance();

            if (\Yii::$app->request->getIsPost())
            {
                $reply->load(\Yii::$app->request->post());

                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($reply);
                }

                if ($reply->validate()) {
                    $reply->save();
                    return $this->redirect(['tasks/view', 'id' => $reply->task_id]);
                }
            }

    }

    public function actionAccept($id)
    {   $reply=Replies::findOne($id);
        $task=Tasks::findOne($reply->task_id);
        $reply->is_approved = 1;
        $task->task_status = 'STATUS_PROCESSING';
        $task->task_performer = $reply->user_id;
        $task->save(false);
        $reply->save(false);
        return $this->redirect(['tasks/view', 'id' => $reply->task_id]);
    }

    public function actionDecline($id)
    {   $reply=Replies::findOne($id);
        $reply->is_approved = -1;
        $reply->save(false);
    }

    public function actionCancel($id)
    {
        $reply=Replies::findOne($id);
        $task_id = $reply->task_id;
        $reply->delete();
        return $this->redirect(['tasks/view', 'id' => $task_id]);
    }

    public function actionFinish($id)
    {
        /**
         * @var Task $task
         */
        $task = Tasks::findOne($id);
        $user = Users::findOne($task->task_performer);
        $opinion = Opinions::getInstance();

        if (Yii::$app->request->isPost) {
            $opinion->load(Yii::$app->request->post());
            if ($opinion->validate()) {
                $task->task_status = 'STATUS_DONE';
                $user->done_tasks+=1;
                $task->save(false);
                $user->save(false);
                $opinion->save();
            }
        }

        return $this->redirect(['tasks/view', 'id' => $task->task_id]);
    }
}