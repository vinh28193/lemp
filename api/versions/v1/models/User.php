<?php

namespace api\versions\v1\models;

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
class User extends \common\models\User implements RateLimitInterface,Linkable
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
            'status' => function (){ 
                return self::getStatusLabel(true);
            },
            'created_at' => function(){
                return Yii::$app->formatter->asDatetime($this->created_at);
            },
            'updated_at' => function(){
                return Yii::$app->formatter->asDatetime($this->updated_at);
            },
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
            'publicIdentity',
            'userProfile',
        ];
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

    /**
     * Returns a list of links.
     *
     * Each link is either a URI or a [[Link]] object. The return value of this method should
     * be an array whose keys are the relation names and values the corresponding links.
     *
     * If a relation name corresponds to multiple links, use an array to represent them.
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
            'avatar' => $this->userProfile->getAvatar(Yii::getAlias('@web/storages/user/default.jpg')),
        ];
    }
}
