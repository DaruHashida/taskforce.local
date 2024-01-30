<?php

namespace src\logic;

use frontend\models\Opinions;
use frontend\models\Tasks;

class FinishAction extends Action
{
    public function getName(): string
    {
        return ('Завершить');
    }
    protected function getInnerName(): string
    {
        return('act_finish');
    }
    static function getUserProperties(int $user_id, object $obj): bool
    {
        return ($obj->task_host == $user_id);
    }

    public function getButton(): string
    {
        return ('<a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>');
    }

    public function getForm($task_id): string
    {
        $performer_id = Tasks::findOne($task_id)->task_performer;
        $view = require 'C:\OSPanel\domains\taskforce.local\init\yii-application\frontend\views\replies\opinion.php';
        return $view;
    }
}
