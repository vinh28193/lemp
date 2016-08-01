<?php
/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   3.1.0
 */

namespace backend\widgets;

use Yii;
use kartik\base\Widget;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

use yii\web\View;
use yii\web\JsExpression;

/**
 * Enhances the Yii GridView widget with various options to include Bootstrap specific styling enhancements. Also
 * allows to simply disable Bootstrap styling by setting `bootstrap` to false. Includes an extended data column for
 * column specific enhancements.
 *
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class Grid extends GridView
{

    const COLUMN_CHECKBOK = '\kartik\grid\CheckboxColumn';
    const COLUMN_SERIAL = 'kartik\grid\SerialColumn';
    const COLUMN_DATA = 'kartik\grid\DataColumn';
    const COLUMN_ACTION = 'kartik\grid\ActionColumn';

    public $title;
    public $pjaxId = 'pjax-';
    public $exportFileName = 'defaultName';

    public function init()
    {
        parent::init();

        $this->title = $this->getView()->title;
        $this->registerConfig();
        $this->parseColumn();
    }
    public function run(){
        parent::run();
    }
    protected function registerConfig(){
        $this->perfectScrollbar = true;
        $this->panel = [
            'heading'=> Html::encode($this->title),
            'type'=> self::TYPE_DEFAULT,
            'before'=> Html::a('<i class="glyphicon glyphicon-import"></i>', ['import'], ['class' => 'btn btn-default w-md m-b-5']),
            'after'=>  false,
            'footer'=>false
        ];
        $this->pjax = true ;
        $this->pjaxSettings = [
            'neverTimeout' => true,
            'beforeGrid' => false,
            'afterGrid '=> false,
        ];
        $this->toolbar = [
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
        ];
        
    }
    protected function parseColumn(){
        $columnList = [];
        $columnOptions = [
            'format' => 'raw',
            'hAlign' => Grid::ALIGN_CENTER ,
            'vAlign' => Grid::ALIGN_MIDDLE,
            'noWrap' => false,
            'pageSummary' => false,
        ];
        $columnHeader = [
            ['class' => self::COLUMN_SERIAL],
            ['class' => self::COLUMN_CHECKBOK]
        ];
        $columnList = array_merge($columnHeader,$columnList);
        return $this->columns;
    }
    protected function initBootstrapStyle(){
        parent::initBootstrapStyle();
        Html::addCssClass($this->containerOptions, 'dataTables_wrapper dt-bootstrap no-footer');
        Html::addCssClass($this->tableOptions, 'dataTable no-footer');
        Html::addCssClass($this->headerRowOptions, 'sticky-table-header fixed-solution');
        Html::addCssClass($this->filterRowOptions, 'dataTables_filter');

    }
    protected function initToggleData(){
        if (!$this->toggleData) {
            return;
        }
        $totalCount = number_format($this->dataProvider->getTotalCount());
        $defaultOptions = [
            'maxCount' => 10000,
            'minCount' => 500,
            'confirmMsg' => 'There are '.$totalCount.' records. Are you sure you want to display them all?',
            'all' => [
                'icon' => '<i class="glyphicon glyphicon-resize-full"></i>',
                'label' => false,
                'class' => 'btn btn-default m-b-5',
                'title' => 'Show all data'
            ],
            'page' => [
                'icon' => '<i class="glyphicon glyphicon-resize-small"></i>',
                'label' => false,
                'class' => 'btn btn-default m-b-5',
                'title' => 'Show first page data'
            ],
        ];
        $this->toggleDataOptions = ArrayHelper::merge($defaultOptions, $this->toggleDataOptions);
        $tag = $this->_isShowAll ? 'page' : 'all';
        $options = $this->toggleDataOptions[$tag];
        $this->toggleDataOptions[$tag]['id'] = $this->_toggleButtonId;
        $icon = ArrayHelper::remove($this->toggleDataOptions[$tag], 'icon', '');
        $label = !isset($options['label']) ? $defaultOptions[$tag]['label'] : $options['label'];
        if (!empty($icon)) {
            $label = $icon ." ". $label;
        }
        $this->toggleDataOptions[$tag]['label'] = $label;
        if (!isset($this->toggleDataOptions[$tag]['title'])) {
            $this->toggleDataOptions[$tag]['title'] = $defaultOptions[$tag]['title'];
        }
        $this->toggleDataOptions[$tag]['data-pjax'] = $this->pjax ? "true" : false;
    }
    protected function initExport(){
        if ($this->export === false) {
            return;
        }
        $this->exportConversions = ArrayHelper::merge(
            [
                ['from' => self::ICON_ACTIVE, 'to' => 'Active'],
                ['from' => self::ICON_INACTIVE, 'to' => 'Inactive']
            ],
            $this->exportConversions
        );

        $this->export = ArrayHelper::merge(
            [
                'label' => '',
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
            ],
            'menuOptions' => ['class' => 'dropdown-menu dropdown-menu-right '],
            ],
            $this->export
        );
        
        $title = empty($this->caption) ? $this->title : $this->caption;
        $pdfHeader = [
            'L' => [
                'content' => $this->title .'Export (PDF)',
                'font-size' => 8,
                'color' => '#333333'
            ],
            'C' => [
                'content' => $title,
                'font-size' => 16,
                'color' => '#333333'
            ],
            'R' => [
                'content' => 'Generated: ' . date("D, d-M-Y g:i a T"),
                'font-size' => 8,
                'color' => '#333333'
            ]
        ];
        $pdfFooter = [
            'L' => [
                'content' => "Dump of ".$this->title,
                'font-size' => 8,
                'font-style' => 'B',
                'color' => '#999999'
            ],
            'R' => [
                'content' => '[ {PAGENO} ]',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#333333'
            ],
            'line' => true,
        ];
        $defaultExportConfig = [
            self::HTML => [
                'label' => 'HTML',
                'icon' => 'floppy-saved',
                'iconOptions' => ['class' => 'text-info'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => $this->exportFileName,
                'alertMsg' => 'The HTML export file will be generated for download.',
                'options' => [
                    'title' => 'Hyper Text Markup Language'
                ],
                'mime' => 'text/html',
                'config' => [
                    'cssFile' => 'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css'
                ]
            ],
            self::CSV => [
                'label' => 'CSV',
                'icon' => 'floppy-open',
                'iconOptions' => ['class' => 'text-primary'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => $this->exportFileName,
                'alertMsg' => 'The CSV export file will be generated for download.',
                'options' => [
                    'title' => 'Comma Separated Values'
                ],
                'mime' => 'application/csv',
                'config' => [
                    'colDelimiter' => ",",
                    'rowDelimiter' => "\r\n",
                ]
            ],
            self::TEXT => [
                'label' => 'Text',
                'icon' => 'floppy-save',
                'iconOptions' => ['class' => 'text-muted'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' =>  $this->exportFileName,
                'alertMsg' => 'The TEXT export file will be generated for download.',
                'options' => [
                    'title' => 'Tab Delimited Text'
                ],
                'mime' => 'text/plain',
                'config' => [
                    'colDelimiter' => "\t",
                    'rowDelimiter' => "\r\n",
                ]
            ],
            self::EXCEL => [
                'label' => 'Excel',
                'icon' => 'floppy-remove',
                'iconOptions' => ['class' => 'text-success'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' =>  $this->exportFileName,
                'alertMsg' =>  'The EXCEL export file will be generated for download.',
                'options' => [
                    'title' => 'Microsoft Excel 95+'
                ],
                'mime' => 'application/vnd.ms-excel',
                'config' => [
                    'worksheet' => 'ExportWorksheet',
                    'cssFile' => ''
                ]
            ],
            self::PDF => [
                'label' => 'PDF',
                'icon' => 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' =>  $this->exportFileName,
                'alertMsg' => 'The PDF export file will be generated for download.',
                'options' => ['title' => 'Portable Document Format'],
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
                        'SetHeader' => [
                            ['odd' => $pdfHeader, 'even' => $pdfHeader]
                        ],
                        'SetFooter' => [
                            ['odd' => $pdfFooter, 'even' => $pdfFooter]
                        ],
                    ],
                    'options' => [
                        'title' => $title,
                        'subject' => 'PDF export generated by kartik-v/yii2-grid extension',
                        'keywords' =>'krajee, grid, export, yii2-grid, pdf'
                    ],
                    'contentBefore' => '',
                    'contentAfter' => ''
                ]
            ],
            self::JSON => [
                'label' => 'JSON',
                'icon' => 'floppy-open',
                'iconOptions' => ['class' => 'text-warning'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => $this->exportFileName,
                'alertMsg' =>'The JSON export file will be generated for download.',
                'options' => [
                    'title' =>'JavaScript Object Notation'
                ],
                'mime' => 'application/json',
                'config' => [
                    'colHeads' => [],
                    'slugColHeads' => false,
                    'jsonReplacer' => new JsExpression("function(k,v){return typeof(v)==='string'?$.trim(v):v}"),
                    'indentSpace' => 4
                ]
            ],
        ];
        $this->exportConfig = self::parseExportConfig($this->exportConfig, $defaultExportConfig);
    }
    
}
