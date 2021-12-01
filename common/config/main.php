<?php
return [
    'bootstrap' => [
        'queue', // Компонент регистрирует свои консольные команды
    ],
    'modules' => [
        'debug' => [
            'class' => \yii\debug\Module::class,
            'panels' => [
                'queue' => \yii\queue\debug\Panel::class,
            ],
        ],
    ],


    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'viewPath' => '@common/mail',
            'htmlLayout' => 'layouts/main-html',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['manager-admin@site.com' => 'From Manager Post Queue'],
            ],
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'kaktuasan777@gmal.com',
                'password' => 'kaktuasan0712',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],

];
