<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'app\modules\ModuleBootstrap',
        'log'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset'
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'vSxSyMP8B2JlY4VZpkMij_AgCQeFVLGE'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'user' => [
            'class'           => 'app\components\User',
            'identityClass'   => 'app\components\Identity',
            'enableAutoLogin' => false,
            'enableSession'   => false,
        ],
        'errorHandler' => [
            'errorAction' => 'v1/default/error'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl'       => true,
            'enableStrictParsing'   => true,
            'showScriptName'        => false,
            'rules' => [
                '/' => 'v1/default/index',
                // defaults
                'GET,POST <module:v1>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                'OPTIONS <module:v1>/<controller:\w+>/<action:\w+>' => '<module>/default/options'
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module'
        ],
    ],
    'params' => $params,
];

return $config;