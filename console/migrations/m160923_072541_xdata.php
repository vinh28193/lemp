<?php

use yii\db\Query;
use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Console;
use common\models\User;

class m160923_072541_xdata extends Migration
{
   
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        //user
        $time = microtime(true);
        Console::stdout('initialisation user'); Console::stdout("\n");
        $user =  new User;
        Console::stdout('set username is "webmaster"'); Console::stdout("\n");
        $user->username = 'webmaster';
        Console::stdout('set email is "webmaster@example.com"'); Console::stdout("\n");
        $user->email = 'webmaster@example.com';
        Console::stdout('set password is "webmaster"'); Console::stdout("\n");
        $user->setPassword('webmaster');
        $user->username = 'webmaster';
        $user->save();
        Console::stdout('initialisation done.User:'.$user->getId().' (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n");
    }

    public function safeDown()
    {
        $userId = 1;
        Console::stdout('remove user : '.$userId); Console::stdout("\n");
        $this->delete('user', ['id' => 1]);
    }
}
