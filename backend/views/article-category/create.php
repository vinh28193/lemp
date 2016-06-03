<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = 'Create Article Category';
$this->params['breadcrumbs'][] = ['label' => 'Article Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default" id="article-category-create">
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