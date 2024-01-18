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

$this->registerJs(<<<JS
    document.querySelector('main').classList.add('main-content--left');

    let downloadedImg = document.querySelector('#picture');
    let fileChooser = document.querySelector('#fileInput');
    fileChooser.addEventListener('change', () => {
        const file = fileChooser.files[0];
        const fileName = file.name.toLowerCase();

        const matches = FILE_TYPES.some((it) => {
            return fileName.endsWith(it);
        });

        if (matches) {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                downloadedImg.src = reader.result;
            });
            reader.readAsDataURL(file);
        }
    });
    JS, View::POS_READY);
?>
<div class="left-menu left-menu--edit">
    <h3 class="head-main head-task">Настройки</h3>
    <ul class="side-menu-list">
        <li class="side-menu-item side-menu-item--active">
            <a class="link link--nav">Мой профиль</a>
        </li>
        <li class="side-menu-item">
            <a href="/settings/securitysettings" class="link link--nav">Безопасность</a>
        </li>
    </ul>
</div>
<div class="my-profile-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <form>
        <h3 class="head-main head-regular">Мой профиль</h3>
        <div class="photo-editing">
            <div>
                <p class="form-label">Аватар</p>
                <img class="avatar-preview" id="picture" src="<?=$picture_addr?>" width="83" height="83">
            </div>
            <?=$form->field($model,'imageFile',[
                'inputOptions' => [
                    'id' => 'fileInput',
                ],
            ])->fileInput()->label('Сменить аватар')?>
        </div>
        <div class="form-group">
            <?=$form->field($model,'user_name')->label('Ваше имя',['class'=>'control-label'])?>
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <?=$form->field($model,'email')->label('Email',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
            <div class="form-group">
                <?=$form->field($model,'birthday')->input('date')->label('День рождения',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
        </div>
        <div class="half-wrapper">
            <div class="form-group">
                <?=$form->field($model,'phone')->label('Номер телефона',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
            <div class="form-group">
                <?=$form->field($model,'telegram')->label('Telegram',['class'=>'control-label'])?>
                <span class="help-block">Error description is here</span>
            </div>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'description')->textarea(['rows' => '6'])->label('Информация о себе',['class'=>'control-label']) ?>
            <span class="help-block">Error description is here</span>
        </div>
        <div class="form-group">
            <div class="checkbox-profile">
                <?= $form->field($model,'specialities')->checkboxList( array_column($categories, 'name', 'id') ,[
                    'item' => function($index, $label, $name, $checked, $value) {
                        $options = array_merge(['label' => $label, 'value' => $value], []);
                        return '<div>' . Html::checkbox($name, $checked, $options) . '</div>';
                    }
                ]) ?>
            </div>
        </div>
        <button type="submit" class="button button--blue">Сохранить</button>
        <?php ActiveForm::end();?>
</div>
