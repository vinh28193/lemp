<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use common\models\User;

$security = Yii::$app->getSecurity();

return [
	'id' => $index + 1,
    'username' => $faker->userName,
    'auth_key' => $security->generateRandomString(),
    'access_token' => $security->generateRandomString(),
    'password_hash' => $security->generatePasswordHash('password_' . $index),
    'password_reset_token' => $security->generateRandomString() . '_' . time(),
    'oauth_client' => 'resgister',
	'oauth_client_id' => $security->generateRandomString(20),
    'email' => $faker->email,
    'status' => User::STATUS_ACTIVE,
    'created_at' => time(),
    'updated_at' => time(),
];
