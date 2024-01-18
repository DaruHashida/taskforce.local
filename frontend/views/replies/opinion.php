<?php
use yii\widgets\ActiveForm;
use frontend\models\Opinions;
use frontend\helpers\UIHelper;
$user_id = Yii::$app->getUser()->getIdentity()->user_id;
$opinion = Opinions::getInstance();
?>
<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin(['action'=>Yii::$app->request->baseUrl.'/replies/finish/'.$task_id]);?>
                <div class="form-group">
                    <?=$form->field($opinion,'description')->textarea()->label('Ваш комментарий')?>
                    <?= $form->field($opinion, 'rate', ['template' => '{label}{input}' . UIHelper::showStarRating(0, 'big', 5, true) . '{error}'])
                        ->hiddenInput(); ?>
                    <?=$form->field($opinion,'responsor_id')->hiddenInput(['value'=>$user_id])->label(false)?>
                    <?=$form->field($opinion,'user_id')->hiddenInput(['value'=>$user_id])->label(false)?>
                </div>
                    <input type="submit" class="button button--pop-up button--blue" value="Завершить">
                    <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>
