<?php
use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;
use common\models\User;
use common\models\UserProfile;

class m130524_201442_init extends Migration
{

    const DRIVRE = 'mysql';
    const FOREIGNKEY_USER_USERPROFILE = 'fk-user-id-user_profile-user_id';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === self::DRIVRE) {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(User::tableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string(32),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'oauth_secret' => $this->string(),
            'oauth_id' => $this->string(),
            'email' => $this->string()->notNull(),
            'type' => $this->string()->defaultValue(User::TYPE_DEFAULT),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer()
        ], $tableOptions);

        $this->createTable(UserProfile::tableName(), [
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

        $this->addForeignKey(
            self::FOREIGNKEY_USER_USERPROFILE, 
            UserProfile::tableName(), 
            'user_id', 
            User::tableName(), 
            'id', 
            'CASCADE', 
            'CASCADE'
            );
    }
    public function down()
    {
        $this->dropForeignKey(self::FOREIGNKEY_USER_USERPROFILE, UserProfile::tableName());
        
        $this->dropTable(UserProfile::tableName());
        $this->dropTable(User::tableName());
    }
}