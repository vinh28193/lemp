<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%application}}`
 * - `{{%category}}`
 */
class m160923_072330_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'app_id' => $this->integer()->notNull(),
            'title' => $this->string(512)->notNull(),
            'slug' => $this->string(1024)->notNull(),
            'parent_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `app_id`
        $this->createIndex(
            'idx-category-app_id',
            '{{%category}}',
            'app_id'
        );

        // add foreign key for table `{{%application}}`
        $this->addForeignKey(
            'fk-category-app_id',
            '{{%category}}',
            'app_id',
            '{{%application}}',
            'id',
            'CASCADE'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-category-parent_id',
            '{{%category}}',
            'parent_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            'fk-category-parent_id',
            '{{%category}}',
            'parent_id',
            '{{%category}}',
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
            'fk-category-app_id',
            'category'
        );

        // drops index for column `app_id`
        $this->dropIndex(
            'idx-category-app_id',
            'category'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            'fk-category-parent_id',
            'category'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-category-parent_id',
            'category'
        );

        $this->dropTable('category');
    }
}
