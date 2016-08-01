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
        'css/animate.css',
        'css/bootstrap-reset.css',
        'css/style.css',
        'css/helper.css',
    ];
    public $js = [
        'js/wow.min.js',
        'js/jquery.app.js',
        'js/jquery.chat.js',
        'js/jquery.todo.js',
    ];
    public $depends = [
        'yii\web\JQueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\FontAwesomeAsset',
        'backend\assets\Html5ShivAsset',
        'backend\assets\OwlCarouselAsset'
    ];
}