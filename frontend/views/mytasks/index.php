<?php
/**
 * @var Task[] $models
 * @var $this View
 */

use frontend\models\Tasks;
use frontend\models\TasksQuery;
use frontend\models\Categories;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
?>
<div class="left-menu">
        <h3 class="head-main head-task">Мои задания</h3>
        <ul class="side-menu-list">
            <li class="side-menu-item side-menu-item--active">
                <a class="link link--nav" href="/mytasks/indexnew">Новые</a>
            </li>
            <li class="side-menu-item">
                <a href="/mytasks/indexprocessing" class="link link--nav">В процессе</a>
            </li>
            <li class="side-menu-item">
                <a href="/mytasks/indexdone" class="link link--nav">Закрытые</a>
            </li>
        </ul>
    </div>
    <div class="left-column left-column--task">
        <h3 class="head-main head-regular">Новые задания</h3>
        <?php if (count($models) != 0):?>
        <?php foreach ($models as $model):?>
        <?php
        $relative_string = Yii::$app->formatter->asRelativeTime($model->task_creation_date);
        $nazad = strpos($relative_string," назад");
        $relative_string_bez_nazad = str_replace(' назад','',$relative_string);
        ?>
        <div class="task-card">
            <div class="header-task">
                <a  href="http://taskforce.local/tasks/<?=$model->id?>" class="link link--block link--big"><?=Html::encode($model->task_title)?></a>
                <p class="price price--task"><?=$model->task_price.' ₽';?></p>
            </div>
            <p class="info-text"><?=$nazad?"<span class=\"current-time\">$relative_string_bez_nazad </span> назад":
                    "<span class=\"current-time\">$relative_string</span>"?></p>
            <p class="task-text"><?=Html::encode(BaseStringHelper::truncate($model->task_description, 200));?>
            </p>
            <div class="footer-task">
                <p class="info-text town-text"><?=$model->task_coordinates;?></p>
                <p class="info-text category-text"><?=$model->task_category;?></p>
                <a href="http://taskforce.local/tasks/<?=$model->id?>" class="button button--black">Смотреть Задание</a>
            </div>
        </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>