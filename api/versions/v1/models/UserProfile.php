<?php

namespace api\versions\v1\models;

use Yii;
use yii\web\Link;
use yii\web\Linkable;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * UserProfile is the resources
 *
 */
class UserProfile extends \common\models\UserProfile
{

    /**
     * @inheritdoc
     *
     * The default implementation returns the names of the columns whose values have been populated into this record.
     */
    public function fields()
    {
        return [
            'firstname',
            'middlename',
            'lastname',
            'locale',
            'gender',
            'phone',
            'address1',
            'address1',
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
            'avatar',
            'fullName'
        ];
    }

}
