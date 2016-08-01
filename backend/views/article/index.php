<?php


use backend\widgets\Grid;
use common\models\Article;
use common\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    [
        'class' => 'kartik\grid\CheckboxColumn'
    ],
    [
        'class' => 'kartik\grid\SerialColumn'
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'title',
        'format' => 'raw',
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Article::find()->orderBy('title')->asArray()->all(), 'title', 'title'), 
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'Any title'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'short_description',
        'format' => 'raw',
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Article::find()->orderBy('short_description')->asArray()->all(), 'short_description', 'short_description'), 
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'Any author'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'description',
        'format' => 'raw',
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Article::find()->orderBy('description')->asArray()->all(), 'description', 'description'), 
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'Any author'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'body',
        'format' => 'ntext',
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'Any author'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'category_id',
        'format' => 'raw',
        'value'=>function ($model, $key, $index, $widget) { 
            return $model->category->title ;  
        },
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(ArticleCategory::find()->asArray()->all(), 'id', 'title'), 
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'Any Category'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'view',
        'format' => 'raw',
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        // 'filterType'=>GridView::FILTER_SELECT2,
        // 'filter'=> ArrayHelper::map(Article::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
        // 'filterWidgetOptions'=>[
        //     'pluginOptions'=>['allowClear'=>true],
        // ],
        // 'filterInputOptions'=>['placeholder'=>'Any author'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'status',
        'format' => 'raw',
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        'filterType'=>Grid::FILTER_SELECT2,
        'filter'=> ['STATUS_NEW','STATUS_PUBLISHED','STATUS_DRAFT'], 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Any author'],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'published_at',
        'format' =>  ['date', 'php:Y-m-d H:i:s'],
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        'filterType'=>Grid::FILTER_DATE,
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'updated_at',
        'format' =>  ['date', 'php:Y-m-d H:i:s'],
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => false,
        'pageSummary' => false,
        'filterType'=>Grid::FILTER_DATE,
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' =>'{view} {update} {delete}',
        'viewOptions'=>['class' => 'btn btn-icon btn-info m-b-5'],
        'updateOptions'=>['class' => 'btn btn-icon btn-primary m-b-5'],
        'deleteOptions'=>['class' => 'btn btn-icon btn-danger m-b-5'],
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'hAlign' => Grid::ALIGN_CENTER ,
        'vAlign' => Grid::ALIGN_MIDDLE,
        'noWrap' => true,
    ],

];
echo  Grid::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $columns,
]); ?>