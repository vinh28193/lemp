<?php

use yii\db\Migration;
use yii\db\Expression;
use common\models\User;
use common\models\Article;
use common\models\ArticleCategory;

class m160602_034225_article extends Migration
{
    const DRIVRE = 'mysql';
    const FOREIGNKEY_ARTICLECATEGORY_SELECTED = 'fk-article_category-selected';
    const FOREIGNKEY_ARTICLE_ARTICLECATEGORY= 'fk-article_category-id-article_category-category_id';
    const FOREIGNKEY_ARTICLE_AUTHOR = 'fk-article-author';
    const FOREIGNKEY_ARTICLE_UPDATER = 'fk-article-updater';


    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === self::DRIVRE) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(ArticleCategory::tableName(), [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'parent_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(ArticleCategory::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable(Article::tableName(), [
            'id' => $this->primaryKey(),
            'slug' => $this->string(1024)->notNull(),
            'title' => $this->string(512)->notNull(),
            'short_description' => $this->string(1024),
            'description' => $this->text(),
            'body' => $this->text()->notNull(),
            'category_id' => $this->integer(),
            'author_id' => $this->integer(),
            'updater_id' => $this->integer(),
            'view' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Article::STATUS_NEW),
            'published_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey(self::FOREIGNKEY_ARTICLECATEGORY_SELECTED, 
            ArticleCategory::tableName(), 
            'parent_id', 
            ArticleCategory::tableName(), 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        $this->addForeignKey(self::FOREIGNKEY_ARTICLE_ARTICLECATEGORY, 
            Article::tableName(),
            'category_id', 
            ArticleCategory::tableName(), 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
        $this->addForeignKey(
            self::FOREIGNKEY_ARTICLE_UPDATER, 
            Article::tableName(),
            'updater_id', 
            User::tableName(), 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
        $this->addForeignKey(
            self::FOREIGNKEY_ARTICLE_AUTHOR, 
            Article::tableName(),
            'author_id', 
            User::tableName(), 
            'id', 
            'CASCADE', 
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(self::FOREIGNKEY_ARTICLE_AUTHOR, Article::tableName());
        $this->dropForeignKey(self::FOREIGNKEY_ARTICLE_UPDATER, Article::tableName());
        $this->dropForeignKey(self::FOREIGNKEY_ARTICLE_ARTICLECATEGORY, Article::tableName());
        $this->dropForeignKey(self::FOREIGNKEY_ARTICLECATEGORY_SELECTED, ArticleCategory::tableName());

        $this->dropTable(Article::tableName());
        $this->dropTable(ArticleCategory::tableName());
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
