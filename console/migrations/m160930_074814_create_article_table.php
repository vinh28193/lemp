<?php

use yii\db\Migration;
use common\models\User;
use common\models\Article;
use common\models\Category;

/**
 * Handles the creation of table `{{%article}}`.
 * Has foreign keys to the tables:
 *
 * - `category`
 * - `author`
 * - `updater`
 */
class m160930_074814_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(Article::tableName(), [
            'id' => $this->primaryKey(),
            'title' => $this->string(512)->notNull(),
            'slug' => $this->string(1024)->notNull(),
            'short_description' => $this->string(1024),
            'description' => $this->text(),
            'body' => $this->text(),
            'view' => $this->integer(),
            'category_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(1)->notNull(),
            'published_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            'idx-article-category_id',
            Article::tableName(),
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-article-category_id',
            Article::tableName(),
            'category_id',
            Category::tableName(),
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            'idx-article-author_id',
            Article::tableName(),
            'author_id'
        );

        // add foreign key for table `author`
        $this->addForeignKey(
            'fk-article-author_id',
            Article::tableName(),
            'author_id',
            User::tableName(),
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-article-updater_id',
            Article::tableName(),
            'updater_id'
        );

        // add foreign key for table `updater`
        $this->addForeignKey(
            'fk-article-updater_id',
            Article::tableName(),
            'updater_id',
            User::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-article-category_id',
            Article::tableName()
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-article-category_id',
            Article::tableName()
        );

        // drops foreign key for table `author`
        $this->dropForeignKey(
            'fk-article-author_id',
            Article::tableName()
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-article-author_id',
            Article::tableName()
        );

        // drops foreign key for table `updater`
        $this->dropForeignKey(
            'fk-article-updater_id',
            Article::tableName()
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-article-updater_id',
            Article::tableName()
        );

        $this->dropTable(Article::tableName());
    }
}
