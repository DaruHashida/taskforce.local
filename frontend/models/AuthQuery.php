<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Auth]].
 *
 * @see Auth
 */
class AuthQuery extends \yii\db\ActiveQuery
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
