<?php


use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Article;
use yii\helpers\Html;
use yii\helpers\FileHelper;
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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'kartik-sheet-style'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'panel' => [
            'heading'=> Html::encode($this->title),
            'type'=> GridView::TYPE_DEFAULT,
            'before'=> Html::a('<i class="glyphicon glyphicon-import"></i>', ['import'], ['class' => 'btn btn-default w-md m-b-5']),
            'after'=>  false,
            'footer'=>false
        ],
        'pjax' => true,
        'pjaxSettings'=>[
            'neverTimeout' => true,
            'options' => ['id' => 'article-index-pjax'],
            'beforeGrid' => false,
            'afterGrid '=> false,
        ],
        'toolbar' => [
            [
                'content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>',['create'] ,[
                        'title'=> 'New:'.$this->title, 
                        'class'=>'btn btn-primary w-md m-b-5'
                    ]) . ' '.
                    Html::a('<i class="glyphicon glyphicon-refresh"></i>', ['index'], [
                        'class' => 'btn btn-default', 
                        'title' =>'Reset Grid'
                    ]),
            ],
            '{export}',
            '{toggleData}'
        ],
        'export' => [
            'icon' => 'export',
            'label' => false,
            'target' => GridView::TARGET_POPUP,
            'fontAwesome' => false,
            'header' => false,
            'options' => [
                'class' => 'btn btn-default m-b-5'
            ],
            'messages' => [
                'allowPopups' => 'Disable any popup blockers in your browser to ensure proper download.',
                'confirmDownload' => 'Ok to proceed?',
                'downloadProgress' => 'Generating file. Please wait....',
                'downloadProgress' => 'All done! Click anywhere here to close this window, once you have downloaded the file.',
            ]
        ],
        'exportConfig' => [
            GridView::HTML => false,
            GridView::CSV => [
                'label' => Yii::t('kvgrid', 'CSV'),
                'icon' => 'file-code-o', 
                'iconOptions' => ['class' => 'text-primary'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => 'ex'.time('now').'_article',
                'alertMsg' =>'The CSV export file will be generated for download.',
                'options' => [
                    'title' => 'Comma Separated Values'
                    ],
                'mime' => 'application/csv',
                'config' => [
                    'colDelimiter' => ",",
                    'rowDelimiter' => "\r\n",
                ]
            ],
            GridView::TEXT => false,
            GridView::EXCEL => false,
            GridView::PDF => false,
            GridView::JSON => false,
        ],
        'toggleDataOptions'=>[
            'all' => [
                'icon' => 'resize-full',
                'label' => false,
                'class' => 'btn btn-default',
                'title' => 'Show all data'
            ],
            'page' => [
                'icon' => 'resize-small',
                'label' => false,
                'class' => 'btn btn-default',
                'title' => 'Show first page data'
            ],
        ],
        'columns' => [
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
                'hAlign' => GridView::ALIGN_CENTER ,
                'vAlign' => GridView::ALIGN_MIDDLE,
                'noWrap' => true,
                'pageSummary' => false
                // 'filterType'=>GridView::FILTER_SELECT2,
                // 'filter'=> ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
                // 'filterWidgetOptions'=>[
                //     'pluginOptions'=>['allowClear'=>true],
                // ],
                // 'filterInputOptions'=>['placeholder'=>'Any author'],
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'attribute' => 'short_description',
                'format' => 'raw',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'noWrap' => true,
                'pageSummary' => false
                // 'filterType'=>GridView::FILTER_SELECT2,
                // 'filter'=> ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
                // 'filterWidgetOptions'=>[
                //     'pluginOptions'=>['allowClear'=>true],
                // ],
                // 'filterInputOptions'=>['placeholder'=>'Any author'],
            ],
            'description:ntext',
            'body:ntext',
            'category_id',
            'view',
            'status',
            'published_at:dateTime',
            'updated_at:dateTime',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {delete}',
                'viewOptions'=>['class' => 'btn btn-icon btn-info m-b-5'],
                'updateOptions'=>['class' => 'btn btn-icon btn-primary m-b-5'],
                'deleteOptions'=>['class' => 'btn btn-icon btn-danger m-b-5'],
                'headerOptions'=>['class'=>'kartik-sheet-style'],
            ],
        ],
    ]); ?>