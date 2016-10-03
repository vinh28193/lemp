<?php

use yii\helpers\Html;
use backend\widgets\Grid;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_search', ['model' => $searchModel]);
echo Grid::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'id' => 'category_wrapper',
            'class' => 'dataTables_wrapper form-inline dt-bootstrap',
        ],
        'tableOptions' => [
            'id' => 'category-data-table',
            'class' => 'table table-hover table-striped table-bordered',
            'role' => 'grid',
        ],
        'rowOptions' => function ($model, $key, $index, $grid){
            return;
        },
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                     return ['value' => $model->primaryKey];
                }
            ],
            'id',
            'title',
            'slug',
            [
                'attribute' => 'parent_id',
                'format' => 'text',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->parent ? $model->parent->title : 'Root';
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'text',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->getStatusLabels(true);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options =[
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-info btn-flat'
                        ];
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options =[
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-primary btn-flat'
                        ];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'delete' => function ($url, $model, $key) {
                        $options =[
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class' => 'btn btn-danger btn-flat',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]);
?>
