<?php
/**
 *
 */
use frontend\models\Tasks;
use frontend\models\TasksQuery;
use frontend\models\Categories;
use frontend\models\Replies;
use frontend\models\Users;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\web\View;
use src\logic\ReactAction;
use frontend\assets\AppAsset;
use frontend\assets\YandexAsset;
AppAsset::register($this);
YandexAsset::register($this);
$auth = Yii::$app->getUser()->getIdentity();
$actions = $data->possibleAction($auth->id,$data->task_status);
$coords = Html::encode($data->task_coordinates);
$adress_arr = explode(',',$coords);
$city_from_map = '';
?>
<div class="left-column">
    <div class="head-wrapper">
        <h3 class="head-main"><?=Html::encode($data->task_title)?></h3>
        <p class="price price--big"><?=$data->task_price.' ₽'?></p>
    </div>
    <p class="task-description">
        <?=$data->task_description?></p>
    <?php foreach($actions as $action):?>
        <?=$action->getButton()?>
    <?php endforeach;?>
    <?php if ($data->task_coordinates): ?>
        <?php $city = \frontend\models\Cities::findOne([$auth->user_city])?>

        <?php
        if ($city) {
            $lat = $city->lat;
            $long = $city->long;
            $city_name = $city->city ?? '';
            $fuladdr = $city_name . ',' . Html::encode($data->task_coordinates);

            $this->registerJs(<<<JS
    ymaps.ready(init);
    
    function init(){
        
        var myMap = new ymaps.Map("map", {
            center:["$lat","$long"],
            zoom: 16
        });
        // добавляем метку города
        
        firstGeoObject = new ymaps.GeoObject(
            {
                geometry:
                    { type: "Point",
                      coordinates: ["$lat", "$long"],
                    },
                properties:
                    {
                        iconCaption:"$city_name"
                    }
            }, 
            {
                preset: 'islands#darkBlueDotIconWithCaption',
                draggable:false
            }
        );
        myMap.geoObjects.add(firstGeoObject);
        
        ymaps.geocode("$coords", 
        {
            results:1
        }).then(function (res) {
            var secondGeoObject = res.geoObjects.get(0);
            secondGeoObject.properties.set('iconCaption',"$data->task_coordinates")
            secondGeoObject.options.set('preset', 'islands#redDotIconWithCaption');
            myMap.geoObjects.add(secondGeoObject);
            myMap.setBounds(myMap.geoObjects.getBounds());
            
            const city = secondGeoObject.getLocalities().join(', ');
            document.querySelector('.town').innerHTML = city;
            const addr = secondGeoObject.getAddressLine();
            document.querySelector('#address').innerHTML = addr; 
        });
        myMap.controls.remove('trafficControl');
        myMap.controls.remove('searchControl');
        myMap.controls.remove('geolocationControl');
        myMap.controls.remove('typeSelector');
        myMap.controls.remove('fullscreenControl');
        myMap.controls.remove('rulerControl');
    } 
    JS, View::POS_READY);
        }
        else{
            $this->registerJs(<<<JS
    ymaps.ready(init);
    
    function init(){
        var secondGeoObject = null,
        cord=null;
        ymaps.geocode("$coords", 
        {
            results:1
        }).then(function (res) {
            secondGeoObject = res.geoObjects.get(0);
            secondGeoObject.properties.set('iconCaption',"$data->task_coordinates")
            secondGeoObject.options.set('preset', 'islands#redDotIconWithCaption');
            cord = secondGeoObject.geometry.getCoordinates();
            
            const city = secondGeoObject.getLocalities().join(', ');
            document.querySelector('.town').innerHTML = city;
            const addr = secondGeoObject.getAddressLine();
            document.querySelector('#address').innerHTML = addr;
            return cord;
        }).then(function(cords)
        {
            var myMap = new ymaps.Map("map", {
            center: cord,
            zoom: 16,
        });
             myMap.geoObjects.add(secondGeoObject);
             myMap.setBounds(myMap.geoObjects.getBounds());
             myMap.controls.remove('trafficControl');
             myMap.controls.remove('searchControl');
             myMap.controls.remove('geolocationControl');
             myMap.controls.remove('typeSelector');
             myMap.controls.remove('fullscreenControl');
             myMap.controls.remove('rulerControl');
        }
        )

    } 
    JS, View::POS_READY);


        }
        ?>
        <div class="task-map">
            <div class="map" id="map"> </div>
            <p class="map-address town"></p>
            <p class="map-address" id ="address"></p>
        </div>
    <?php endif; ?>
    <h4 class="head-regular">Отклики на задание</h4>
    <?php foreach ($task_replies as $reply):?>
    <?php
    if(Users::find()->where(['id'=>$reply->user_id])->exists())
    {$comment_user = Users::find()->where(['id'=>$reply->user_id])->one();}
    ?>
    <div class="response-card">
        <img class="customer-photo" src="<?=Yii::$app->request->baseUrl;?><?=$comment_user->user_img?>" width="146" height="156" alt="Фото заказчиков">
        <div class="feedback-wrapper">
            <a href="/users/<?=$comment_user->id?>" class="link link--block link--big"><?=$comment_user->user_name?></a>
            <div class="response-wrapper">
                <div class="stars-rating small">
                    <?php for($i=0;$i<$comment_user->reputation;$i++)
                    {echo("<span class=\"fill-star\"> </span>");}?>
                    <?php
                    if ($comment_user->reputation<5)
                    {for($i=0;$i<(5-$comment_user->reputation);$i++)
                    {echo("<span> </span>");}}?>
                </div>
                <p class="reviews"><?=$comment_user->responces_count?> отзыва</p>
            </div>
            <p class="response-message">
                <?=$reply->description?>
            </p>
        </div>
        <div class="feedback-wrapper">
            <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->asRelativeTime($reply->dt_add)?> </span></p>
            <p class="price price--small"><?=$reply->price.' ₽'?></p>
        </div>
        <?php if ($auth->id == $data->task_host):?>
        <div class="button-popup">
            <?php if ($data->task_status != 'STATUS_PROCESSING'):?>
                <a href="<?=Yii::$app->request->baseUrl.'/replies/accept/'.$reply->id?>" class="button button--blue button--small">Принять</a>
                <a href="<?=Yii::$app->request->baseUrl.'/replies/decline/'.$reply->id?>" class="button button--orange button--small">Отказать</a>
            <?php endif;?>
            <?php elseif ($auth->id==$reply->user_id && !$data->task_performer):?>
                <div class="button-popup">
                    <a href="<?=Yii::$app->request->baseUrl.'/replies/cancel/'.$reply->id?>" class="button button--orange button--small">Удалить</a>
                </div>
            <?php endif;?>
        </div>
        <?php endforeach;?>
    </div>
    <div class="right-column">
        <div class="right-card black info-card">
            <h4 class="head-card">Информация о задании</h4>
            <dl class="black-list">
                <dt>Категория</dt>
                <dd><?=$data->task_category?></dd>
                <dt>Дата публикации</dt>
                <dd><?=Yii::$app->formatter->asRelativeTime(strtotime($data->task_creation_date))?></dd>
                <dt>Срок выполнения</dt>
                <dd><?=Yii::$app->formatter->asRelativeTime(strtotime($data->task_expire_date))?></dd>
                <dt>Статус</dt>
                <dd><?=$data->getRussianStatusName()?></dd>
            </dl>
        </div>
        <?php if ($data->task_file):?>
            <div class="right-card white file-card">
                <h4 class="head-card">Файлы задания</h4>
                <ul class="enumeration-list">
                    <li class="enumeration-item">
                        <a href="<?=$data->task_file?>" class="link link--block link--clip"><?=$data->task_file_name?></a>
                        <p class="file-size"><?=$data->task_file_size?></p>
                    </li>
                </ul>
            </div>
        <?php endif;?>
        <?php foreach($actions as $action):?>
            <?=$action->getForm($data->id,$auth->id)?>
        <?php endforeach;?>
    </div>