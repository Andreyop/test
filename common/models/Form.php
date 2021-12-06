<?php

namespace common\models;

use common\models\User;
use Yii;
use yii\db\ActiveRecord;

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
class Form extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */

    public $contact_name;
    public $contact_email;
    public $salary;
    public $position_description;
    public $dateStart;
    public $dateEnd;
    public $datePostAt;

    /**
     * @var mixed|null
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
            [['type', 'company_name', 'position'], 'required'/*, 'on' => self::SCENARIO_CONTACT*/],
            [['dateEnd'], 'required', 'when' => function ($model) {
                return $model->type == 'descriptive';
            }, 'whenClient' => "function (attribute, value) {
                         return $('#type').val() == 'descriptive';
                }", 'skipOnEmpty' => false],

            [['contact_email'], 'required', 'when' => function ($model) {
                return $model->type == 'contact';
            }, 'whenClient' => "function (attribute, value) {
                         return $('#type').val() == 'contact';
                }", 'skipOnEmpty' => false/*, 'on' => self::SCENARIO_CONTACT*/],

            [['type'], 'string', 'max' => 32],
            [['company_name', 'position'], 'string', 'max' => 128/*, 'on' => self::SCENARIO_CONTACT*/],

            [['contact_name', 'contact_email'], 'string', 'max' => 256],
            [['contact_email'], 'email', 'when' => function ($model) {
                return $model->type == 'contact';
            }, 'whenClient' => "function (attribute, value) {
                         return $('#type').val() == 'contact';
                }", 'message' => 'Неверный электронный адрес'],

            [['salary'], 'integer'],
            [['position_description'], 'string', 'max' => 128],


            ['dateStart', 'date', 'format' => 'php:d.m.Y', 'max' => date('d.m.Y'), 'when' => function ($model) {
                return $model->type == 'descriptive';
            }, 'whenClient' => "function (attribute, value) {
                         return $('#type').val() == 'descriptive';
                }", 'skipOnEmpty' => false],
            ['dateStart', 'default', 'value' => date('d.m.Y')],


            ['dateEnd', 'date', 'format' => 'php:d.m.Y'], //формат модели с которой будем работать

            ['dateEnd', 'validDateEnd', 'when' => function ($model) {
                return $model->dateStart != '' && $model->type == 'descriptive';
            }, 'whenClient' => "function (attribute, value) {
                         return $('#form-datestart').val() != '' && $('#type').val() == 'descriptive';
                }", 'skipOnError' => false],

            [['datePostAt'], 'date', 'format' => 'php:d.m.Y H:i', 'min' => date('d.m.Y H:i')],
            [['datePostAt'], 'default', 'value' => date('d.m.Y H:i')],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Тип формы',
            'company_name' => 'Название компании',
            'position' => 'Должность',
            'contact_name' => 'Контактное имя',
            'contact_email' => 'Контактный email',
            'position_description' => 'Описание должности',
            'salary' => 'Размер заработной платы',
            'dateStart' => 'Дата начала',
            'dateEnd' => 'Дата окончания',
            'datePostAt' => 'Дата размещения'
        ];
    }


    public function validDateEnd($attribute, $params)
    {
        $minDateEnd = (isset($this->dateStart)) ? strtotime($this->dateStart . '+3 month') : strtotime('+3 month');
        $dateEnd = strtotime($this->dateEnd);
        if ($dateEnd < $minDateEnd) {
            $this->addError($attribute, 'Минимальная дата окончания - ' . date('d.m.Y', $minDateEnd));
        }
    }

    /**
     * Gets query for [[ContactPost]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactPost()
    {
        return $this->hasOne(ContactPost::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[DescriptivePost]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDescriptivePost()
    {
        return $this->hasOne(DescriptivePost::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[PostsQueues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostsQueues()
    {
        return $this->hasMany(PostsQueue::class, ['post_id' => 'id']);
    }


    public function beforeSave($insert)
    {
        if (empty($this->datePostAt)) {
            $this->datePostAt = date('d.m.Y');
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if ($this->type === 'contact') {
                $contact_post = new ContactPost();
                $contact_post->post_id = $this->id;
                $contact_post->contact_name = $this->contact_name;
                $contact_post->contact_email = $this->contact_email;
                $contact_post->save();

            } else {
                $descriptive_post = new DescriptivePost();
                $descriptive_post->post_id = $this->id;
                $descriptive_post->position_description = $this->position_description;
                $descriptive_post->salary = $this->salary;
                $descriptive_post->dateStart = $this->dateStart;
                $descriptive_post->dateEnd = $this->dateEnd;
                $descriptive_post->save();
            }

            $post_queue = new PostsQueue();
            $post_queue->post_id = $this->id;
            $post_queue->datePostAt = $this->datePostAt;
            $post_queue->save();

        }
    }

    public function sendMail($id)
    {
        $sender = Form::find()->with('postsQueues')->with('descriptivePost')->with('contactPost')->where('id = :id', [':id' => $id])->limit(1)->one();
        $email = \common\models\Admin::find()->orderBy(['id' => SORT_DESC])->one();
        $admin_email = $email->admin_email;
        // Set layout params
        \Yii::$app->mailer->getView()->params['CompanyName'] = $sender->company_name;
        $result = \Yii::$app->mailer->compose(
            'views/contact-html', ['sender' => $sender])->setTo($admin_email)
            ->setSubject('Данные из очереди')
            ->send();
        // Reset layout params
        \Yii::$app->mailer->getView()->params['CompanyName'] = null;
        if ($result) {
            $notification = PostsQueue::find()->where('post_id = :post_id', [':post_id' => $id])->limit(1)->one();
            $notification->notification_sent_at = 1;
            $notification->save();
        }
        return $result;
    }


}
