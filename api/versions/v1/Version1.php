<?php

namespace api\versions\v1;

use Yii;
use yii\base\Module;
use yii\rest\Controller;
use yii\web\Request;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\filters\Cors;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class Version1 extends Module
{
    public $controllerNamespace = 'api\versions\v1';

    public $urlRuleClass = 'yii\rest\UrlRule';

    public function behaviors(){
    	$behaviors = parent::behaviors();
    	$behaviors = ArrayHelper::merge([
    		'authenticator' => [
                'class' => CompositeAuth::className(),
                'except' => ['options'],
                'authMethods' => [
                    'httpBasic' => ['class' => HttpBasicAuth::className()],
                    'httpBearer' => ['class' => HttpBearerAuth::className()],
                    'queryParam' => ['class' => QueryParamAuth::className()],
                ],
            ],
    		'corsFilter' => [
                // Cors filter implements [Cross Origin Resource Sharing](http://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
                'class' => Cors::className(),
                // The current requested
                'request' => Request::className(),
                // The response to be sent
                'response' => Response::className(),
                'actions' => [
                    'index',    // List resources page by page;
                    'view',     // Return the details of a specified resource;
                    'create',   // Create a new resource;
                    'update',   // Update an existing resource;
                    'delete',   // Delete the specified resource;
                    'options',  // Return the supported HTTP methods.
                ],
                'cors' => [
                    // Restrict access to All Origin 
                    'Origin' => ['*'],
                    // Allow  'GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD' and 'OPTIONS' methods
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'], 
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow Credentials
                    'Access-Control-Allow-Credentials' => null,
                    // Allow OPTIONS caching '3600 sec'
                    'Access-Control-Max-Age' => 3600,
                    // Allow the following HTTP header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => [
                        'X-Pagination-Total-Count',  // The total number of resources;
                        'X-Pagination-Page-Count',   // The number of pages;
                        'X-Pagination-Current-Page', // The current page (1-based);     
                        'X-Pagination-Per-Page',     // The number of resources in each page;
                        'Link'                       // A set of navigational links allowing client to traverse the resources page by page;
                    ],
                ],
            ],  
    		//'contentNegotiator'=> ['formats' => ['text/html' => Response::FORMAT_HTML]]
    	],$behaviors);
        return $behaviors;
    }

    public function init()
    {
        parent::init();
    }

}