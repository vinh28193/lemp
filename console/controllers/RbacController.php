<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\db\Query;
use yii\db\Expression;
use common\models\User;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;

class RbacController extends Controller
{
    private $_auth;

    public function init(){
        parent::init();
        if($this->_auth || !isset($this->_auth)){
            $this->_auth = $this->_authManager();
        }
        return $this->_auth;
    }

    private function _authManager(){
        return Yii::$app->authManager;
    }

    public function actionIndex()
    {
        $this->_registerPermission();
        $this->_registerRole();
        $this->_assignUser();
    }
    private function _registerPermission(){
        $permissions = [
            'create','update','delete'
        ];
        foreach ($permissions as $name) {
            $token = "create Permission: ". $name ;
            $this->stdout($token, Console::FG_RED);
            $permission = $this->_auth->createPermission($name);
            $this->_auth->add($permission);
        }

    }
    private function _registerRole(){
        $roles = [
            'administrator','manager','user'
        ];
        foreach ($roles as $name) {
            $token = "create Role: ". $name ;
            $this->stdout($token, Console::FG_RED);
            $role = $this->_auth->createRole($name);
            $this->_auth->add($role);
        }
    }
    private function _registerRule(){
        return false;
    }
    private function _assignUser(){
       $userIDs = (new Query)->select('id')->from(User::tableName())->all();
       $userIDs = ArrayHelper::getColumn($userIDs,'id',false);
       foreach ($userIDs as $id) {
           if($id <= 5){
                $role = $this->_auth->getRole('administrator');
                $this->_auth->assign($role,$id);
           }elseif($id > 5 && $id <= 15){
                $role = $this->_auth->getRole('manager');
                $this->_auth->assign($role,$id);
           }else{
                $role = $this->_auth->getRole('user');
                $this->_auth->assign($role,$id);
           }    
       }
    }
}