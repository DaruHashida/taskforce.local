<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Opinions]].
 *
 * @see Opinions
 */
class OpinionsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Opinions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Opinions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
