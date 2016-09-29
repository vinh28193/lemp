<?php
namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\JQueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\AdminLteAsset',
        'backend\assets\FontAwesomeAsset',
    ];
}