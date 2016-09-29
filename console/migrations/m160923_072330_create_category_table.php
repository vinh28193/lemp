<?php

use yii\db\Migration;
use common\models\Category;
/**
 * Handles the creation of table `{{%category}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category}}`
 */
class m160923_072330_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(Category::tableName(), [
            'id' => $this->primaryKey(),
            'title' => $this->string(512)->notNull(),
            'slug' => $this->string(1024)->notNull(),
            'parent_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            'idx-category-parent_id',
             Category::tableName(),
            'parent_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            'fk-category-parent_id',
            Category::tableName(),
            'parent_id',
            Category::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            'fk-category-parent_id',
            Category::tableName()
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-category-parent_id',
            Category::tableName()
        );

        $this->dropTable(Category::tableName());
    }
}
