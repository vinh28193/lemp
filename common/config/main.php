<?php
return [
    'id' => 'whisnew',
    'name' => 'Whisnew',
    'version' => '1.1',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage'=>'en',
    'language'=>'en',
    'timeZone' => 'UTC',
    'bootstrap' => ['log'],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
        	'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => '.',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['guest'],
        ],
        'urlManager' => [
        	'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'i18n' => [
            'class' => 'yii\i18n\I18N',
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'zh-CN',
                    'basePath' => '@app/messages'
                ],
            ],
        ],
    ]
];