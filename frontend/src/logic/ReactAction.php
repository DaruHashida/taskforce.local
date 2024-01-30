<?php

    namespace src\logic;

use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\Replies;
use yii\widgets\ActiveForm;
use Yii;

class ReactAction extends Action
{
    public function getName(): string
    {
        return ('Откликнуться');
    }
    protected function getInnerName(): string
    {
        return('act_react');
    }
    static function getUserProperties(int $user_id, object $obj): bool
    {
        return (($obj->task_host != $user_id) && (Replies::findOne(['user_id' => $user_id,'task_id' => $obj->id]) === null));
    }

    public function getButton(): string
    {
        return ('<a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>');
    }

    public function getForm($task_id): string
    {
        $view = require Yii::$app->basePath . '\views\replies\reply.php';
        return($view);
    }

    public function getReply(): object
    {
        return (new Replies());
    }
}
