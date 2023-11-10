<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => [
        'log',
        'queue',
    ],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'    => [
        'library'    => [
            'class' => 'app\modules\library\Module',
        ],
        'user'    => [
            'identityClass' => 'yii2mod\user\models\UserModel',
            'on afterLogin' => function ($event) {
                $event->identity->updateLastLogin();
            },
        ],
    ],
    'components' => [
        'queue' => [
            'class'     => \yii\queue\amqp\Queue::class,
            'host'      => 'rabbitmq',
            'port'      => env('RABBIT_PORT'),
            'user'      => env('RABBIT_USER'),
            'password'  => env('RABBIT_PASS'),
            'queueName' => env('RABBIT_QUEUE'),
        ],
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => env('COOKIE_VALIDATION_KEY'),
        ],
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache' //Включаем кеширование
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'htmlLayout'       => false,
            'textLayout'       => false,
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.yandex.ru',
                'username'   => env('MAILER_USERNAME'),
                'password'   => env('MAILER_PASSWORD'),
                'port'       => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig'    => [
                'from'    => [env('SENDER_EMAIL') => 'Почиталка'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '/login'                  => '/site/login',
                '/logout'                 => '/site/logout',
                '/signup'                 => '/site/signup',
                '/request-password-reset' => '/site/request-password-reset',

                '/about'    => '/site/about',
                '/contacts' => '/site/contact',

                'library/report' => 'library/default/report',

                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>'          => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'i18n'         => [
            'translations' => [
                'yii2mod.user' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/user/messages',
                ],
            ],
        ],
    ],
    'params'     => $params,
];

//if (YII_ENV_DEV) {
//    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['*', '::1'],
//    ];
//
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['89.113.137.100', '::1', '*'],
//    ];
//}

return $config;
