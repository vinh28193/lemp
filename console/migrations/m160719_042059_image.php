<?php

use yii\db\Migration;

class m160719_042059_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'target' => $this->string(512),
            'target_id' => $this->integer(),
            'width' => $this->integer(),
            'height' => $this->integer(),
            'quality' => $this->integer(),
            'type' => $this->string(64),
            'size' => $this->integer(10),
            'is_thumbnail' =>$this->smallInteger()->notNull()->defaultValue(1),
            'status' =>$this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%image}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
