<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=form',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'useFileTransport' => false,
            'viewPath' => '@common/mail',
            'htmlLayout' => 'layouts/main-html',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['manager-admin@site.com' => 'Создана задача об отправке данных'],
            ],

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'encryption' => 'tls',
                'host' => 'smtp.gmail.com',
                'username' => 'po4ta.adm.test@gmail.com',
                'password' => 'zxc111zxc',
                'port' => '587',

//                'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
            ],
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'as log' => \yii\queue\LogBehavior::class,
            'as behavior' => \backend\components\BehaviorErrorQueue::class,
            'db' => 'db', // компонент подключения к БД
            'tableName' => '{{%queue}}', // Имя таблицы
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],

    ],
];
