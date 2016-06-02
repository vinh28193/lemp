<?php

namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Class FontAwesomeAsset
 * @package backend\assets
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    public $css = [
        'css/font-awesome.min.css'
    ];
}