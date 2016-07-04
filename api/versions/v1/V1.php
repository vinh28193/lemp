<?php

namespace api\versions\v1;

use Yii;
use yii\base\Module;
use yii\rest\Controller;
use yii\rest\UrlRule;
use yii\web\Request;
use yii\web\Response;
use yii\heples\Url;
use yii\heples\ArrayHelper;
use yii\heples\StringHelper;
use yii\filters\Cors;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth

class V1 extends Module
{
    public $controllerNamespace = 'api\versions\v1';

    public $urlRuleClass = UrlRule::className();

    public function behavior(){
    	$behaviors = panent::behavior();
    	$behaviors = ArrayHelper::merger([
    		'authenticator' => QueryParamAuth::className(),
    		'corsFilter' => Cors::className(),
    		'contentNegotiator'=> ['formats' => ['text/html' => Response::FORMAT_HTML]]
    	],$behaviors);
    	return $behaviors;
    }

    public function init()
    {
        parent::init();
        $this->registerUrl();
    }

    public function registerUrl(){
        $request = Yii::$app->getRequest();
        $urlManager Yii::$app->getUrlManager();
        if(!$request instanceof Request){

        }
        $method = $request->getMethod();

        $createRule = [
            'class' => $this->urlRuleClass,
        ];

    }
}