<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\LoginForm;
use src\logic\DataToSQLConverter;
use yii\widgets\ActiveForm;
AppAsset::register($this);
?>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <h2>Вход на сайт</h2>
        <p>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true,
                'class'=>'enter-form-email input input-middle',
                'labelOptions'=>['Email','class'=>'form-modal-description'],
                'id'=>'enter-email',
                'name'=>'enter-email'
            ]) ?>
        </p>
        <p>
            <?= $form->field($model, 'password')->passwordInput(['class'=>'form-modal-description',
                'labelOptions'=>['Пароль','class'=>'form-modal-description'],
                'id'=>'enter-password',
                'name'=>'enter-email'])?>
        </p>
        <?= Html::submitButton('Войти', ['class' => 'button']) ?>
        <?php ActiveForm::end(); ?>
        <button class="form-modal-close" type="button">Закрыть</button>
