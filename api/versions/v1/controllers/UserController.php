<?php
namespace api\versions\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\HttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class UserController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'api\versions\v1\models\User';

    /**
     * @inheritdoc
     */
    public function behaviors(){
        $behaviors = parent::behaviors();
        if(isset($behaviors['authenticator'])){
            unset($behaviors['authenticator']);
        };
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['index','view'],
            'authMethods' => [
                [
                    'class' => HttpBasicAuth::className(),
                    'auth' => [$this,'findLogin']
                ],
                HttpBearerAuth::className(),
                QueryParamAuth::className()
            ]
        ];
        return $behaviors;
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }
    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $class = $this->modelClass;
        return new ActiveDataProvider([
            'query' => $class::find()
        ]);
    }
    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $class = $this->modelClass;
        $model = $class::findOne($id);
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }

    /**
     * @param $username
     * @return null|static
     * @throws NotFoundHttpException
     */
    public function findLogin($username, $password) {
        $class = $this->modelClass;
        $user = $class::findByLogin($username);
        return $user->validatePassword($password) ? $user : null;
    }

}