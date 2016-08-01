<?php

namespace backend\assets;
use yii\web\AssetBundle;
/**
 * Class OwlCarouselAsset
 * @package backend\assets
 */
class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@bower/owl.carousel/dist';
    public $css = [
        'assets/owl.carousel.css'
    ];
    public $js = [
    	'owl.carousel.js'
   
    ];
}