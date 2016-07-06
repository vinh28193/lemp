<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'api\versions\v1\Version1',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\resources\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'class' => 'yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' =>['v1/user','v1/article'],'only' => ['index', 'view', 'options']],
                'GET v1/user' => 'v1/user/index',
                'GET v1/article' => 'v1/article/index',
                'GET v1/user/<id:\d+>' => 'v1/user/view',
                'OPTIONS v1/user' => 'v1/user/index',
                'OPTIONS v1/user/<id:\d+>' => 'v1/user/view'
            ],
        ],
    ],
    'params' => $params,
];



