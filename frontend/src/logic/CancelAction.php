<?php

    namespace src\logic;

class CancelAction extends Action
{
    public function getName(): string
    {
        return ('Отменить');
    }

    protected function getInnerName(): string
    {
        return ('act_cancel');
    }

    static function getUserProperties(int $user_id, object $obj): bool
    {
        return ($obj->task_host == $user_id);
    }

    public function getButton(): string
    {
        return ('<a href="#" class="button button--orange action-btn" data-action="cancel">Отменить задание</a>');
    }

    public function getForm($task_id): string
    {
        return("<section class=\"pop-up pop-up--cancel pop-up--close\">
    <div class=\"pop-up--wrapper\">
        <h4>Отмена задания</h4>
        <p class=\"pop-up-text\">
            <b>Внимание!</b><br>
            Вы собираетесь удалить это задание.<br>
        </p>
        <a class=\"button button--pop-up button--orange\" href=\"/tasks/cancel/$task_id\">Удалить</a>
        <div class=\"button-container\">
            <button class=\"button--close\" type=\"button\">Закрыть окно</button>
        </div>
    </div>
</section>");
    }
}
