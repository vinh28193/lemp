<?php

use yii\helpers\Html;
use backend\widgets\Grid;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
// echo $this->render('_search', ['model' => $searchModel]);
echo Grid::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'slug',
            'parent_id',
            'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
?>
