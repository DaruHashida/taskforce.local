<?php


namespace frontend\helpers;
use yii\helpers\Html;

class UIHelper
{
    public static function showStarRating($value, $size = 'small', $starsCount = 5, $active = false)
    {
        $stars = '';

        for ($i = 1; $i <= $starsCount; $i++) {
            $className = $i <= $value ? 'fill-star' : '';
            $stars .= Html::tag('span', '&nbsp;', ['class' => $className]);
        }

        $className = 'stars-rating ' . $size;

        if ($active) {
            $className .= ' active-stars';
        }

        $result = Html::tag('div', $stars, ['class' => $className]);

        return $result;
    }
}