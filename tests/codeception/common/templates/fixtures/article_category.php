<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\ArticleCategory;

$title = $faker->jobTitle;
$slug = Inflector::slug($title);
$currentRecord = $index + 1;
$parentId  = $currentRecord <= 10 ? null : $faker->numberBetween(1,10);
return [
	
    'title' => $title,
    'slug' => $slug,
    'parent_id' => $parentId,
    'status' => $faker->numberBetween(0,1),
    'created_at' => time(),
    'updated_at' => time(),
];
