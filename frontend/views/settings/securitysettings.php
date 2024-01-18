<?php
use frontend\models\Tasks;
use frontend\models\TasksQuery;
use frontend\models\Categories;
use frontend\models\Replies;
use frontend\models\Users;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\web\UrlManage;
use frontend\assets\AppAsset;
AppAsset::register($this);
?>
<script>
    document.querySelector('main').classList.add('main-content--left');
</script>
<div class="left-menu left-menu--edit">
    <h3 class="head-main head-task">Настройки</h3>
    <ul class="side-menu-list">
        <li class="side-menu-item ">
            <a href="/settings/index" class="link link--nav">Мой профиль</a>
        </li>
        <li class="side-menu-item side-menu-item--active">
            <a class="link link--nav">Безопасность</a>
        </li>
    </ul>
</div>
<div class="my-profile-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <form>
        <h3 class="head-main head-regular">Настройки пароля</h3>
        <div class="half-wrapper">
            <div class="form-group">
                <?=$form->field($model,'old_password')->passwordInput()->label('Введите старый пароль',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <?=$form->field($model,'new_password')->passwordInput()->label('Введите новый пароль',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
            <div class="form-group">
                <?=$form->field($model,'password_repeat')->passwordInput()->label('Повтор нового пароля',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
        </div>
        <button type="submit" class="button button--blue">Сохранить</button>
        <?php ActiveForm::end();?>
</div>