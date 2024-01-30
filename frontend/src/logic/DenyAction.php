<?php

    namespace src\logic;

    use Yii;

class DenyAction extends Action
{
    public function getName(): string
    {
        return ('Провалено');
    }
    protected function getInnerName(): string
    {
        return('act_deny');
    }
    static function getUserProperties(int $user_id, object $obj): bool
    {
        return ($obj->task_performer == $user_id);
    }

    public function getButton(): string
    {
        return ('<a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
        ');
    }

    public function getForm($task_id): string
    {
        $base_url = Yii::$app->request->baseUrl;
        return ("<section class=\"pop-up pop-up--refusal pop-up--close\">
    <div class=\"pop-up--wrapper\">
        <h4>Отказ от задания</h4>
        <p class=\"pop-up-text\">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <a class=\"button button--pop-up button--orange\" href=\"$base_url/replies/deny/$task_id\">Отказаться</a>
        <div class=\"button-container\">
            <button class=\"button--close\" type=\"button\">Закрыть окно</button>
        </div>
    </div>
</section>");
    }
}
