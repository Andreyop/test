<?php
return [

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


        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],

];
