<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use common\models\UserProfile;

return [
	'user_id' => $index + 1,
    'firstname' => $faker->randomKey([$faker->firstNameMale,$faker->firstNameFemale]),
    'middlename' => $faker->randomKey([$faker->titleMale,$faker->titleFemale]),
    'lastname' => $faker->lastName,
    'avatar_path' => 'user/no-user.jpg',
    'avatar_base_url' => Yii::getAlias('@storages'),
    'locale' => Yii::$app->language,
	'gender' => $faker->numberBetween(UserProfile::GENDER_MALE,UserProfile::GENDER_FEMALE),
    'address1' => $faker->address,
    'address2' => $faker->address,
    'phone' => $faker->phoneNumber,
];