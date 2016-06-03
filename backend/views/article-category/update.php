<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = 'Update Article Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Article Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel panel-default" id="article-category-update">
    <div class="panel-heading"> 
        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3> 
    </div> 
    <div class="panel-body"> 
        <?= $this->render('_form', [
	        'model' => $model,
	        'articleCategories' => $articleCategories
	    ]) ?>
    </div> 
</div>