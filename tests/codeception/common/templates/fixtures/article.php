<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use yii\db\Query;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

use common\models\Article;
use common\models\ArticleCategory;
use common\models\User;

$currentRecord = $index + 1;
$title = $faker->words(25,true);
$slug = Inflector::slug($title);

$identitys = (new Query)->select('id')->from(User::tableName())->where('status = 1')->all();
$identitys = ArrayHelper::getColumn($identitys,'id');
$identity = $faker->randomElement($identitys);

$categoryIds=(new Query)->select('id')->from(ArticleCategory::tableName())->where('status = 1 and parent_id is not null')->all();
$categoryIds = ArrayHelper::getColumn($categoryIds,'id');
$categoryId = $faker->randomElement($categoryIds);

return [
    'id' => $currentRecord,
    'title' => $title,
    'slug' => $slug,
    'short_description' => $faker->realText(255),
    'description' => $faker->realText(300),
    'body' => $faker->realText(),
    'category_id' => $categoryId,
    'thumbnail_base_url' => Yii::getAlias('@storages'),
    'thumbnail_path' => 'article/no-article.jpg',
    'author_id' => $identity,
    'updater_id' => $identity,
    'view' => $faker->numberBetween(1,10000),
    'status' => $faker->numberBetween(0,1),
    'published_at' => time(),
    'updated_at' => time(),
];
