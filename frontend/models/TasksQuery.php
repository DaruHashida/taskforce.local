<?php

namespace frontend\models;

/**
 * This is the ActiveQuery class for [[Tasks]].
 *
 * @see Tasks
 */
class TasksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tasks[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tasks|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getSearchQuery()
    {
        $query = self::find();
        $query->where(['status_id'=> 'new']);

        $query->andFilterWhere(['task_category'=>$this->task_category]);

        if ($this->noLocation) {
            $query->andWhere('task_location IS NULL');
        }

        if ($this->noResponses)
        {
            $query->joinWith('replies r')->andWhere('r.id IS NULL');
        }
        if ($this->filterPeriod)
        {
            $query->andWhere('UNIX_TIMESTAMP(tasks.task_creation_date > UNIX_TIMESTAMP()-:period', [':period'=>$this->filterPeriod]);
        }
        return $query->orderBy('task_creation_date DESC');
    }
    
}
