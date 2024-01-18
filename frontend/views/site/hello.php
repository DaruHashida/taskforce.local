<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\LoginForm;
use src\logic\DataToSQLConverter;
use yii\widgets\ActiveForm;
AppAsset::register($this);
?>
<?/*=var_dump(Yii::$app->user)*/?>

<?=var_dump(Yii::$app->getUser()->getIdentity())?>
