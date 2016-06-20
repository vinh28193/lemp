<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;

$css = <<< CSS
    .panel-title {
        font-size: 18px;
        margin-bottom: 0;
        margin-top: 15px;
    }
CSS;
$this->registerCss($css);
?>
<div class="panel panel-default" id="article-category-index">
    <div class="panel-heading"> 
        <?= Html::tag('span',Html::encode($this->title),['class' => 'panel-title pull-left'])?>
        <?= Html::a('Create Article Category', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        <div class="clearfix"></div>
    </div> 
    <div class="panel-body"> 
        <?php Pjax::begin(); ?>   
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'slug',
            'title',
            'short_description',
            'description:ntext',
            // 'body:ntext',
            // 'category_id',
            // 'thumbnail_base_url:url',
            // 'thumbnail_path',
            // 'author_id',
            // 'updater_id',
            // 'view',
            // 'status',
            // 'published_at',
            // 'updated_at',

            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' =>'{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,[
                                    'id' => 'btn-view-'.$key,
                                    'class' => 'btn btn-icon btn-info m-b-5',
                                    'title' => $model->title,
                                    'aria-label' => $model->title,
                                    'data-pjax' => '0',
                                ]);
                            },
                            'update' => function ($url, $model, $key) {
                               return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,[
                                    'id' => 'btn-view-'.$key,
                                    'class' => 'btn btn-icon btn-primary m-b-5',
                                    'title' => $model->title,
                                    'aria-label' => $model->title,
                                    'data-pjax' => '0',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,[
                                    'id' => 'btn-view-'.$key,
                                    'class' => 'btn btn-icon btn-danger m-b-5',
                                    'title' => $model->title,
                                    'aria-label' => $model->title,
                                    'data-confirm' => 'Are you sure you want to delete this item : '. $model->title .' ?',
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]);
                            },

                        ]
                    ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>    
    </div> 
</div>>
