<?php

namespace api\versions\v1;

use Yii;
use yii\base\Module;
use yii\rest\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\heples\Url;
use yii\heples\ArrayHelper;
use yii\heples\StringHelper;
use yii\filters\Cors;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class Version1 extends Module
{
    public $controllerNamespace = 'api\versions\v1';

    public $urlRuleClass = 'yii\rest\UrlRule';

    public function behavior(){
    	$behaviors = panent::behavior();
    	$behaviors = ArrayHelper::merger([
    		'authenticator' => 'yii\filters\auth\QueryParamAuth',
    		'corsFilter' => 'yii\filters\Cors',
    		'contentNegotiator'=> ['formats' => ['text/html' => Response::FORMAT_HTML]]
    	],$behaviors);
        return $behaviors;
    }

    public function init()
    {
        parent::init();
    }

}