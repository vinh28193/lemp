<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%application}}`
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
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'app_id' => $this->integer()->notNull(),
            'username' => $this->string(32),
            'email' => $this->string()->notNull(),
            'oauth_client_id' => $this->string(),
            'oauth_client_secret' => $this->string(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'scenario' => $this->string()->defaultValue('default'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ],$tableOptions);

        // creates index for column `app_id`
        $this->createIndex(
            'idx-user-app_id',
            '{{%user}}',
            'app_id'
        );

        // add foreign key for table `{{%application}}`
        $this->addForeignKey(
            'fk-user-app_id',
            '{{%user}}',
            'app_id',
            '{{%application}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `{{%application}}`
        $this->dropForeignKey(
            'fk-user-app_id',
            '{{%user}}'
        );

        // drops index for column `app_id`
        $this->dropIndex(
            'idx-user-app_id',
            '{{%user}}'
        );

        $this->dropTable('{{%user}}');
    }
}
