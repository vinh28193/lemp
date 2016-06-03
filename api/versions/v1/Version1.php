<?php
namespace api\versions\v1;

use yii\base\Module;

class Version1 extends Module
{
    public $controllerNamespace = 'api\versions\v1\controllers';

    public function init()
    {
        parent::init();
    }
}
