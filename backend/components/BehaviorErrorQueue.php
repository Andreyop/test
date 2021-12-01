<?php


namespace backend\components;


use common\models\Form;
use yii\base\Behavior;
use yii\queue\Queue;


class BehaviorErrorQueue extends Behavior
{

    public function events()
    {
        return [
            Queue::EVENT_AFTER_ERROR => 'afterErrorSend',
        ];
    }


    public function afterErrorSend($event) {

        return \Yii::$app->mailer->compose(
            'views/contact-admin-html', ['event' => $event])->setTo([\Yii::$app->params['formEmail'] => 'Менеджеру-админу'])
            ->setSubject('Сообщение о событии в очереди EVENT_AFTER_EXEC')
            ->send();
    }
}