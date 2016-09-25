<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Controller;
use Yii;

/**
 * Class GlobalVerbFilterBehavior
 * @package common\behaviors
 */
class GlobalVerbFilterBehavior extends Behavior
{

    /**
     * @var array
     * @see \yii\filters\AccessControl::actions
     */
    public $actions = [];

    /**
     * @var string
     */
    public $verbFilter = 'yii\filters\VerbFilter';

    /**
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    public function beforeAction()
    {
        Yii::$app->controller->attachBehavior('verbs', [
            'class' => $this->verbFilter,
            'actions'=> $this->actions
        ]);
    }
}
