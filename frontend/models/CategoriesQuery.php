<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Categories]].
 *
 * @see Categories
 */
class CategoriesQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Categories[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Categories|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
