<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $admin_email
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_email'], 'required',],
            [['admin_email'], 'email',],
            [['admin_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'admin_email' => Yii::t('app', 'Email администратора:'),
        ];
    }
}
