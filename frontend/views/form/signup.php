<?php
use app\models\City;
use app\models\User;
use yii\widgets\ActiveForm;
?>

<div class="center-block">
    <?php $form = ActiveForm::begin();?>
    <div class="registration-form regular-form">
        <h3 class="head-main head-task">Регистрация нового пользователя</h3>
            <?=$form->field($model,'user_name')?>
        <div class="half-wrapper">
            <?=$form->field($model,'user_email')?>
            <?=$form->field($model,'user_city')->dropDownList(array_column($cities, 'city', 'id'))?>
        </div>
        <div class="half-wrapper">
            <?=$form->field($model,'password')->passwordInput()?>
        </div>
        <div class="half-wrapper">
            <?=$form->field($model,'password_repeat')->passwordInput()?>
        </div>
        <?=$form->field($model,'role')->checkbox(['label'=>'Я буду принимать заказы', 'labelOptions'=>['class'=>'control-label checkbox-label']])
        ?>
        <input type="submit" class="button button--blue" value="Создать аккаунт">
        <?php ActiveForm::end();?>
    </div>
</div>
        <!--<form>
            <h3 class="head-main head-task">Регистрация нового пользователя</h3>
            <div class="form-group">
                <label class="control-label" for="username">Ваше имя</label>
                <input id="username" type="text">
                <span class="help-block">Error description is here</span>
            </div>
            <div class="half-wrapper">
                <div class="form-group">
                    <label class="control-label" for="email-user">Email</label>
                    <input id="email-user" type="email">
                    <span class="help-block">Error description is here</span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="town-user">Город</label>
                    <select id="town-user">
                        <option>Москва</option>
                        <option>Санкт-Петербург</option>
                        <option>Владивосток</option>
                    </select>
                    <span class="help-block">Error description is here</span>
                </div>
            </div>
            <div class="half-wrapper">
                <div class="form-group">
                    <label class="control-label" for="password-user">Пароль</label>
                    <input id="password-user" type="password">
                    <span class="help-block">Error description is here</span>
                </div>
            </div>
            <div class="half-wrapper">

                <div class="form-group">
                    <label class="control-label" for="password-repeat-user">Повтор пароля</label>
                    <input id="password-repeat-user" type="password">
                    <span class="help-block">Error description is here</span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label checkbox-label" for="response-user">
                    <input id="response-user" type="checkbox" checked>
                    я собираюсь откликаться на заказы</label>
            </div>
            <input type="submit" class="button button--blue" value="Создать аккаунт">
        </form>-->
    </div>
</div>