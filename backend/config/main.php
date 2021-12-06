<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'timeZone' => 'Europe/Kiev',
    'name' => 'Test',
    'defaultRoute' => 'form/index',
    'layout'=>'test',
    'basePath' => dirname(__DIR__),
    'language' => 'ru',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'queue'],
    'modules' => [],
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
            'csrfParam' => '_csrf-backend',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'mailer' => [
//            'class' => \yii\swiftmailer\Mailer::class,
//            'useFileTransport' => true,
//            'viewPath' => '@common/mail',
//            'htmlLayout' => 'layouts/main-html',
//            'messageConfig' => [
//                'charset' => 'UTF-8',
//                'from' => ['manager-admin@site.com' => 'From Manager Post Queue'],
//            ],

//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => ' smtp-relay.gmail.com',
//                'username' => 'kaktuasan777',
//                'password' => 'kaktuasan0712',
//                'port' => '587',
//                'encryption' => 'tls',
//                'streamOptions' => [ 'ssl' => [ 'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false, ], ]
//            ],
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
//                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
        ],
    ],
    'params' => $params,
];
