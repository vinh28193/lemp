<?php

namespace api\resources;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\RateLimitInterface;
/**
 * User is the resources that may be implemented by an identity object to enforce rate limiting.
 *
 */
class User extends \common\models\User implements RateLimitInterface
{
    /**
     * @var int
     */
    public $rateSize = 3600;

    /**
     * @inheritdoc
     *
     * The default implementation returns the names of the columns whose values have been populated into this record.
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @inheritdoc
     *
     * The default implementation returns the names of the relations that have been populated into this record.
     */
    public function extraFields()
    {
        return [
            'userProfile'
        ]
    }

    /**
     * Returns the maximum number of allowed requests and the window size.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @return array an array of two elements. The first element is the maximum number of allowed requests,
     * and the second element is the size of the window in seconds.
     */
    public function getRateLimit($request, $action){
        return [5000, $this->rateSize];
    }

    /**
     * Loads the number of allowed requests and the corresponding timestamp from a persistent storage.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @return array an array of two elements. The first element is the number of allowed requests,
     * and the second element is the corresponding UNIX timestamp.
     */
    public function loadAllowance($request, $action){

    }

    /**
     * Saves the number of allowed requests and the corresponding timestamp to a persistent storage.
     * @param \yii\web\Request $request the current request
     * @param \yii\base\Action $action the action to be executed
     * @param integer $allowance the number of allowed requests remaining.
     * @param integer $timestamp the current timestamp.
     */
    public function saveAllowance($request, $action, $allowance, $timestamp){

    }
}
