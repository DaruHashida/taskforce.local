<?php
use frontend\models\Users;
use frontend\models\Categories;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;
use frontend\assets\AppAsset;
use function morphos\Russian\pluralize;
use yii\helpers\inflector;
use yii\helpers\BaseInflector;
AppAsset::register($this);
$city = '';
if ($data->id == Yii::$app->user->identity->id)
{
    $city = $data->user_city??'<a href="/settings/index" class="link link--regular">Ваш город</a>';
    $age = $data->getAge() ? Yii::$app->inflection->pluralize($data->getAge(), 'год') : '<a href="/settings/index" class="link link--regular">Ваш возраст</a>';
    $phonenumber = $data->phonnenumber ?? '<a href="/settings/index" class="link link--regular">Ваш телефон</a>';
    $telegram = $data->telegram ?? '<a href="/settings/index" class="link link--regular">Ваш телеграмм</a>';
    $email = $data->user_email ?? '<a href="/settings/index" class="link link--regular">Ваш E-Mail</a>';
}
else
{
    $city = $data->user_city??'Город не указан';
    $age = $data->getAge() ? Yii::$app->inflection->pluralize($data->getAge(), 'год') : 'Возраст не указан';
    $phonenumber = $data->phonnenumber ?? 'Не указан';
    $telegram = $data->telegram ?? 'Не указан';
    $email = $data->user_email ?? 'Не указан';
}
?>
<link rel="stylesheet" type="text/css" href="<?=Yii::$app->request->baseUrl;?>/css/style.css">
<div class="left-column">
    <h3 class="head-main"><?=$data->user_name?></h3>
    <div class="user-card">
        <div class="photo-rate">
            <img class="card-photo" src="<?=$data->user_img?>" width="191" height="190" alt="Фото пользователя">
            <div class="card-rate">
                <?php if ($data->reputation):?>
                <div class="stars-rating big">
                    <?php
                    $stars = '';
                    for($i=0;$i<$data->reputation;$i++)
                    {$stars= $stars."<span class=\"fill-star\"></span>";}
                    if ($data->reputation<5)
                    {for($i=0;$i<(5-$data->reputation);$i++)
                    {$stars= $stars."<span></span>";}}
                    echo($stars);
                    ?>
                </div>
                <?php endif;?>
                <span class="current-rate"><?=$data->reputation??'Пока нет данных о рейтинге)'?></span>
            </div>
        </div>
        <p class="user-description">
            <?=$data->user_description?>
        </p>
    </div>
    <div class="specialization-bio">
        <div class="specialization">
            <p class="head-info">Специализации</p>
            <ul class="special-list">
                <?php if ($data->specialization):?>
                <?php foreach (explode(' ',$data->specialization) as $spec):?>
                <li class="special-item">
                    <a href="/categories/<?=$spec?>" class="link link--regular"><?=Categories::findOne($spec)->name?></a>
                </li>
                <?php endforeach;?>
                <?php else:?>
                    <li class="special-item">
                        <a href="/settings/index" class="link link--regular">Укажите свою специализацию!</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>

        <div class="bio">
            <p class="head-info"> Био</p>
            <p class="bio-info"><span class="country-info">Россия</span>, <span class="town-info"><?=$city?></span>, <span class="age-info"><?=$age?>
            </p>
        </div>
    </div>
    <h4 class="head-regular">Отзывы заказчиков</h4>
    <div class="response-card">
        <img class="customer-photo" src="img/man-coat.png" width="120" height="127" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <p class="feedback">«Кумар сделал всё в лучшем виде. Буду обращаться к нему в
                будущем, если возникнет такая необходимость!»</p>
            <p class="task">Задание «<a href="#" class="link link--small">Повесить полочку</a>» выполнено</p>
        </div>
        <div class="feedback-wrapper">
            <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
            <p class="info-text"><span class="current-time">25 минут </span>назад</p>
        </div>
    </div>
    <div class="response-card">
        <img class="customer-photo" src="img/man-sweater.png" width="120" height="127" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <p class="feedback">«Кумар сделал всё в лучшем виде. Буду обращаться к нему в
                будущем, если возникнет такая необходимость!»</p>
            <p class="task">Задание «<a href="#" class="link link--small">Повесить полочку</a>» выполнено</p>
        </div>
        <div class="feedback-wrapper">
            <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
            <p class="info-text"><span class="current-time">25 минут </span>назад</p>
        </div>
    </div>
</div>
<div class="right-column">
    <div class="right-card black">
        <h4 class="head-card">Статистика исполнителя</h4>
        <dl class="black-list">
            <dt>Всего заказов</dt>
            <dd><?=$data->done_tasks??'0'?> выполнено, <?=$data->failed_tasks??'0'?> провалено</dd>
            <dt>Место в рейтинге</dt>
            <dd>25 место</dd>
            <dt>Дата регистрации</dt>
            <dd><?=Yii::$app->formatter->asDatetime($data->user_registration_date,'long')?></dd>
            <dt>Статус</dt>
            <dd>Открыт для новых заказов</dd>
        </dl>
    </div>
    <div class="right-card white">
        <h4 class="head-card">Контакты</h4>
        <ul class="enumeration-list">
            <li class="enumeration-item">
                <a href="#" class="link link--block link--phone"><?=$phonenumber?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--email"><?=$email?></a>
            </li>
            <li class="enumeration-item">
                <a href="#" class="link link--block link--tg"><?=$telegram?></a>
            </li>
        </ul>
    </div>
</div>