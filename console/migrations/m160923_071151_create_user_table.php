<?php

use yii\db\Migration;
use common\models\User;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m160923_071151_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string(32),
            'email' => $this->string()->notNull(),
            'oauth_client_id' => $this->string(),
            'oauth_client_secret' => $this->string(),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(40),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'scenario' => $this->string()->defaultValue(User::SCENARIO_DEFAULT),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(User::tableName());
    }
}
