<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "descriptive_post".
 *
 * @property int $post_id
 * @property string|null $position_description
 * @property int|null $salary
 * @property int|null $starts_at
 * @property int|null $ends_at
 *
 * @property Post $post
 */
class DescriptivePost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'descriptive_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_description'], 'string'],
            [['salary', 'starts_at', 'ends_at'], 'integer'],
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
            'position_description' => Yii::t('app', 'Position Description'),
            'salary' => Yii::t('app', 'Salary'),
            'starts_at' => Yii::t('app', 'Starts At'),
            'ends_at' => Yii::t('app', 'Ends At'),
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

    public function getDateStart()
    {
        return $this->starts_at ? date('d.m.Y', $this->starts_at) : '';
    }

    public function setDateStart($date)
    {
        $this->starts_at = $date ? strtotime($date) : null;
    }

    public function getDateEnd()
    {
        return $this->ends_at ? date('d.m.Y', $this->ends_at) : '';
    }

    public function setDateEnd($date)
    {
        $this->ends_at = $date ? strtotime($date) : null;
    }
//    /**
//     * {@inheritdoc}
//     * @return \common\models\query\DescriptivePostQuery the active query used by this AR class.
//     */
//    public static function find()
//    {
//        return new \common\models\query\DescriptivePostQuery(get_called_class());
//    }
}
