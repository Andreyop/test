<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\PostsQueue]].
 *
 * @see \common\models\PostsQueue
 */
class PostsQueueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\PostsQueue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\PostsQueue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
