<?php
namespace console\controllers;

use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;

class HelloController extends Controller
{

    public function actionIndex()
    {
        $this->stdout("Hello World.!\n\n", Console::FG_RED);
        $this->stdout("\n");
    }
}