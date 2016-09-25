<?php

namespace backend\widgets;

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

class Grid extends GridView
{
    /**
     * Initializes the grid view.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        Pjax::begin();
        parent::run();
        Pjax::end();
    }
}
