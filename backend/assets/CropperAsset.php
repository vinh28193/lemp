<?php

namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Class CropperAsset
 * @package backend\assets
 */
class CropperAsset extends AssetBundle
{
    public $sourcePath = '@bower/cropper/dist';
    public $css = [
        'cropper.css'
    ];
    public $js = [
        'cropper.js'
    ];
}