<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Auth]].
 *
 * @see Auth
 */
class AuthQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Auth[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Auth|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
