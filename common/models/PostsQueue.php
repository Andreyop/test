<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts_queue".
 *
 * @property int $id
 * @property int $post_id
 * @property int|null $post_at
 * @property int|null $notification_sent_at
 *
 * @property Post $post
 */
class PostsQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id'], 'required'],
            [['post_id', 'post_at', 'notification_sent_at'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'post_at' => Yii::t('app', 'Дата размещения'),
            'notification_sent_at' => Yii::t('app', 'Notification Sent At'),
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
    public function getDatePostAt()
    {
        return $this->post_at ? date('d.m.Y H:i', $this->post_at) : '';
    }

    public function setDatePostAt($date)
    {
        $this->post_at = $date ? strtotime($date) : null;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostsQueueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostsQueueQuery(get_called_class());
    }
}
