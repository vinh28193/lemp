<?php

namespace backend\assets;

use yii\web\AssetBundle;
/**
 * Class Html5shiv
 * @package backend\assets
 */
class Html5ShivAsset extends AssetBundle
{
    public $sourcePath = '@bower/html5shiv';
    public $js = [
        'dist/html5shiv.min.js'
    ];
    public $jsOptions = [
        'condition'=>'lt IE 9'
    ];
}