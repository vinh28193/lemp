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
        'panel' => [
            'heading'=> false,
            'type'=>'success',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
            'after'=> Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
            'footer'=>false
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
            'beforeGrid'=> false,
            'afterGrid'=>'My fancy content after.',
        ],
        'toolbar' => [
            [
                'content'=>
                    Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                        'type'=>'button', 
                        'title'=> 'New:'.$this->title, 
                        'class'=>'btn btn-success'
                    ]) . ' '.
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default', 
                        'title' =>'Reset Grid'
                    ]),
            ],
            '{export}',
            '{toggleData}'
        ],
        'export' => [
            'icon' => '',
            'label' => 'Export',
            'target' => '_popup',
            'fontAwesome' => true,
            'header' => '<li role="presentation" class="dropdown-header">Choose One</li>',
            'options' => ['class' => 'btn btn-default m-b-5'],
            'messages' => [
                'allowPopups' => 'Disable any popup blockers in your browser to ensure proper download.',
                'confirmDownload' => 'Ok to proceed?',
                'downloadProgress' => 'Generating file. Please wait....',
                'downloadProgress' => 'All done! Click anywhere here to close this window, once you have downloaded the file.',
            ]
        ],
        'exportConfig' => [
            GridView::HTML => [
                'label' =>'HTML',
                'icon' => 'file-text',
                'iconOptions' => ['class' => 'text-info'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => 'article',
                'alertMsg' => Yii::t('kvgrid', 'The HTML export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Hyper Text Markup Language')],
                'mime' => 'text/html',
                'config' => [
                    'cssFile' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'
                ]
            ],
            GridView::CSV => [
                'label' => Yii::t('kvgrid', 'CSV'),
                'icon' => 'file-code-o', 
                'iconOptions' => ['class' => 'text-primary'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The CSV export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Comma Separated Values')],
                'mime' => 'application/csv',
                'config' => [
                    'colDelimiter' => ",",
                    'rowDelimiter' => "\r\n",
                ]
            ],
            GridView::TEXT => [
                'label' => Yii::t('kvgrid', 'Text'),
                'icon' => 'file-text-o',
                'iconOptions' => ['class' => 'text-muted'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The TEXT export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Tab Delimited Text')],
                'mime' => 'text/plain',
                'config' => [
                    'colDelimiter' => "\t",
                    'rowDelimiter' => "\r\n",
                ]
            ],
            GridView::EXCEL => [
                'label' => Yii::t('kvgrid', 'Excel'),
                'icon' =>'file-excel-o',
                'iconOptions' => ['class' => 'text-success'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The EXCEL export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95+')],
                'mime' => 'application/vnd.ms-excel',
                'config' => [
                    'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),
                    'cssFile' => ''
                ]
            ],
            GridView::PDF => [
                'label' => Yii::t('kvgrid', 'PDF'),
                'icon' => 'file-pdf-o',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The PDF export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'Portable Document Format')],
                'mime' => 'application/pdf',
                'config' => [
                    'mode' => 'c',
                    'format' => 'A4-L',
                    'destination' => 'D',
                    'marginTop' => 20,
                    'marginBottom' => 20,
                    'cssInline' => '.kv-wrap{padding:20px;}' .
                        '.kv-align-center{text-align:center;}' .
                        '.kv-align-left{text-align:left;}' .
                        '.kv-align-right{text-align:right;}' .
                        '.kv-align-top{vertical-align:top!important;}' .
                        '.kv-align-bottom{vertical-align:bottom!important;}' .
                        '.kv-align-middle{vertical-align:middle!important;}' .
                        '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                        '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                        '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                    'methods' => [
                        'SetHeader' => ['Test Export'],
                        'SetFooter' => ['{PAGENO}']
                    ],
                    'options' => [
                        'title' => $this->title,
                        'subject' => Yii::t('kvgrid', 'PDF export generated by kartik-v/yii2-grid extension'),
                        'keywords' => Yii::t('kvgrid', 'krajee, grid, export, yii2-grid, pdf')
                    ],
                    'contentBefore'=>'',
                    'contentAfter'=>''
                ]
            ],
            GridView::JSON => [
                'label' => Yii::t('kvgrid', 'JSON'),
                'icon' => 'file-code-o',
                'iconOptions' => ['class' => 'text-warning'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => Yii::t('kvgrid', 'grid-export'),
                'alertMsg' => Yii::t('kvgrid', 'The JSON export file will be generated for download.'),
                'options' => ['title' => Yii::t('kvgrid', 'JavaScript Object Notation')],
                'mime' => 'application/json',
                'config' => [
                    'colHeads' => [],
                    'slugColHeads' => false,
                    'jsonReplacer' => null,
                    'indentSpace' => 4
                ]
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
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-eye"></i>', $url,[
                            'id' => 'btn-view-'.$key,
                            'class' => 'btn btn-icon btn-info m-b-5',
                            'title' => $model->title,
                            'aria-label' => $model->title,
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                       return Html::a('<i class="fa fa-pencil"></i>', $url,[
                            'id' => 'btn-view-'.$key,
                            'class' => 'btn btn-icon btn-primary m-b-5',
                            'title' => $model->title,
                            'aria-label' => $model->title,
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete'  => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-trash-o"></i>', $url,[
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
