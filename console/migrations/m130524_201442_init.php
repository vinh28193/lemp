<?php
use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;
class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'oauth_client' => $this->string(),
            'oauth_client_id' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer()
        ], $tableOptions);
        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->primaryKey(),
            'firstname' => $this->string(),
            'middlename' => $this->string(),
            'lastname' => $this->string(),
            'avatar_path' => $this->string(),
            'avatar_base_url' => $this->string(),
            'locale' => $this->string(32)->notNull(),
            'gender' => $this->smallInteger(1),
            'address1' => $this->string(),
            'address2' => $this->string(),
            'phone' => $this->string(20),
        ], $tableOptions);
        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'webmaster',
            'email' => 'webmaster@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('webmaster'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => 1,
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()')
        ]);
         $this->insert('{{%user_profile}}', [
            'user_id'=>1,
            'firstname' => 'Admin',
            'middlename' => 'None',
            'lastname' => 'I',
            'avatar_path' => '',
            'avatar_base_url' => '',
            'locale'=>Yii::$app->sourceLanguage,
            'gender' => 1,
            'address1' => '',
            'address2'  => '',
            'phone' => '0123456789'
        ]);
    }
    public function down()
    {
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->delete('{{%user_profile}}', [
            'user_id' => [1]
        ]);
        $this->delete('{{%user}}', [
            'id' => [1]
        ]);
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}