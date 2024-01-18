<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\LoginForm;
use yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;
AppAsset::register($this);
?>
<link rel="stylesheet" href="<?=Yii::$app->request->baseUrl;?>/css/authchoice.css">

<?php $form = ActiveForm::begin(['enableAjaxValidation'=>true, 'action'=>['login']]); ?>
<h2>Вход на сайт</h2>
<p>
    <?= $form->field($model, 'email', ['labelOptions' => ['class' => 'form-modal-description'],
        'inputOptions' => ['class' => 'enter-form-email input input-middle']]);?>
</p>
<p>
    <?= $form->field($model, 'password', [ 'labelOptions' => ['class' => 'form-modal-description'],
        'inputOptions' => ['class' => 'enter-form-email input input-middle']])->passwordInput();?>
</p>
<p><button class="button" type="submit">Войти</button></p>
<?php ActiveForm::end(); ?>
<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['form/vk'],
    'popupMode' => false
]); ?>
<button class="form-modal-close" type="button">Закрыть</button>
<script src="<?=Yii::$app->request->baseUrl;?>/js/authchoice.js"></script>
