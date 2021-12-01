<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_post".
 *
 * @property int $post_id
 * @property string $contact_name
 * @property string $contact_email
 *
 * @property Post $post
 */
class ContactPost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_name', 'contact_email'], 'required'],
            [['contact_name'], 'string', 'max' => 45],
            [['contact_email'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('app', 'Post ID'),
            'contact_name' => Yii::t('app', 'Contact Name'),
            'contact_email' => Yii::t('app', 'Contact Email'),
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

//    /**
//     * {@inheritdoc}
//     * @return \common\models\query\ContactPostQuery the active query used by this AR class.
//     */
//    public static function find()
//    {
//        return new \common\models\query\ContactPostQuery(get_called_class());
//    }
}
