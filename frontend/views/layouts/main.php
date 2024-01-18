<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use src\logic\DataToSQLConverter;
use yii\helpers\Url;
AppAsset::register($this);
$auth = Yii::$app->getUser()->getIdentity();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Taskforce</title>
    <link rel="stylesheet" type="text/css" href="<?=Yii::$app->request->baseUrl;?>/css/style.css">
</head>
<body>
<?php $this->beginBody() ?>
<?php
/*$sql_done = new DataToSQLConverter('C:\OSPanel\domains\taskforce.local\init\yii-application\frontend\web\data');
$generator = $sql_done->getData();
foreach ($generator as $value) {
    echo "$value\n";
}*/
?>

<header class="page-header">
    <nav class="main-nav">
        <a href='<?=Url::home()?>' class="header-logo">
            <img class="logo-image" src="<?=Yii::$app->request->baseUrl;?>/img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <?php if (!Yii::$app->user->isGuest):?>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item <?php if (Yii::$app->request->url == '/tasks/indexnew') {echo('list-item--active');}?>">
                    <a href="/tasks/indexnew" class="link link--nav">Новое</a>
                </li>
                <li class="list-item <?php if (preg_match('/^\/mytasks/',Yii::$app->request->url)) {echo('list-item--active');}?>">
                    <a href="/mytasks/index" class="link link--nav" >Мои задания</a>
                </li>
                <li class="list-item <?php if (Yii::$app->request->url == '/tasks/add') {echo('list-item--active');}?>">
                    <a href="/tasks/add" class="link link--nav" >Создать задание</a>
                </li>
                <li class="list-item <?php if (preg_match('/^\/settings/',Yii::$app->request->url)) {echo('list-item--active');}?>">
                    <a href="/settings/index" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="user-block">
        <a href="/users/view/<?=Yii::$app->user->getId()?>">
            <img class="user-photo" src="<?=$auth->user_img?>" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name"><?=$auth->user_name?></p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="/settings/index" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="/form/logout" class="link">Выход из системы</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php endif;?>
</header>
<main class="main-content container">
    <?=$content; ?>
</main>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="pop-up pop-up--open">
        <div class="pop-up--wrapper">
            <h4>Не забудьте сохранить пароль!</h4>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
    <div class="overlay db"></div>
<?php else:?>
    <div class="overlay"></div>
<?php endif;?>
<script src="<?=Yii::$app->request->baseUrl;?>/js/main.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>