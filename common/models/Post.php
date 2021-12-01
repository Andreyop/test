<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $type
 * @property string $company_name
 * @property string $position
 *
 * @property ContactPost $contactPost
 * @property DescriptivePost $descriptivePost
 * @property PostsQueue[] $postsQueues
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'company_name', 'position'], 'required'],
            [['type', 'company_name', 'position'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Тип формы'),
            'company_name' => Yii::t('app', 'Название компании'),
            'position' => Yii::t('app', 'Должность'),
        ];
    }


    /**
     * Gets query for [[ContactPost]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ContactPostQuery
     */
    public function getContactPost()
    {
        return $this->hasOne(ContactPost::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[DescriptivePost]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\DescriptivePostQuery
     */
    public function getDescriptivePost()
    {
        return $this->hasOne(DescriptivePost::className(), ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostsQueues]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\PostsQueueQuery
     */
    public function getPostsQueues()
    {
        return $this->hasMany(PostsQueue::className(), ['post_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostQuery(get_called_class());
    }
}
