<?php

use yii\db\Query;
use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;

class m160923_072541_xdata extends Migration
{
   
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        //application
        $this->insert('application', [
            'name' => 'whisnew-dev',
            'title' => 'Whisnew Application'
        ]);

        //user
        $this->insert('user', [
            'id' => 1,
            'app_id' => 1,
            'username' => 'webmaster',
            'email' => 'webmaster@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('webmaster'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'type' => 'default',
            'status' => 1,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()')
        ]);
    }

    public function safeDown()
    {
        $this->delete('user', ['id' => 1]);
        $this->delete('application', ['id' => 1]);
    }
}
