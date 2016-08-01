<?php

use yii\helpers\Html;
use backend\widgets\Detail;
/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= Detail::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'slug',
            'title',
            'short_description',
            'description:ntext',
            'body:ntext',
            'category_id',
            'thumbnail_base_url:url',
            'thumbnail_path',
            'author_id',
            'updater_id',
            'view',
            'status',
            'published_at',
            'updated_at',
        ],
    ]) ?>

</div>
