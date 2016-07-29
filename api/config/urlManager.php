<?php 
	return [
        'enablePrettyUrl' => true,
        'enableStrictParsing' => true,
        'showScriptName' => false,
        'rules' => [
            [
                'class' => 'yii\rest\UrlRule', 
                'controller' =>['v1/user','v1/article'],
                'only' => ['index', 'view', 'options']
            ],
            'GET v1/user' => 'v1/user/index',
            'GET v1/article' => 'v1/article/index',
            'GET v1/user/<id:\d+>' => 'v1/user/view',
            'OPTIONS v1/user' => 'v1/user/index',
            'OPTIONS v1/user/<id:\d+>' => 'v1/user/view'
        ],
    ];
 ?>