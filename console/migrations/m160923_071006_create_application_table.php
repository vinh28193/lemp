<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m160923_071006_create_application_table extends Migration
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
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(12)->notNull()->unique(),
            'title' => $this->string()->notNull(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%application}}');
    }
}
