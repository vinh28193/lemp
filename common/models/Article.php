<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $short_description
 * @property string $description
 * @property string $body
 * @property integer $category_id
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property integer $author_id
 * @property integer $updater_id
 * @property string $view
 * @property integer $status
 * @property integer $published_at
 * @property integer $updated_at
 *
 * @property User $author
 * @property ArticleCategory $category
 * @property User $updater
 * @property ArticleAttachment[] $articleAttachments
 */
class Article extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;
    /**
    * @var mixed thumbnail the attribute for rendering the file input
    * widget for upload on the form
    */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
    */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'published_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            'blameable'=>[
                'class'=> BlameableBehavior::className(),
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'updater_id',
            ],
            'slug'=>[
                'class'=> SluggableBehavior::className(),
                'attribute'=>'title',
                'ensureUnique'=>true,
                'immutable'=>true
            ],
        ];
    }
    /**
     * @inheritdoc
     * @return \common\models\queries\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\ArticleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'body'], 'required'],
            [['description', 'body'], 'string'],
            [['category_id', 'author_id', 'updater_id', 'status', 'published_at', 'updated_at'], 'integer'],
            [['slug', 'short_description', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['view'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'short_description' => 'Short Description',
            'description' => 'Description',
            'body' => 'Body',
            'category_id' => 'Category ID',
            'thumbnail_base_url' => 'Thumbnail Base Url',
            'thumbnail_path' => 'Thumbnail Path',
            'author_id' => 'Author ID',
            'updater_id' => 'Updater ID',
            'view' => 'View',
            'status' => 'Status',
            'published_at' => 'Published At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachment::className(), ['article_id' => 'id']);
    }

     /**
     *  get status label
     *  @param bool $status default false if not set.
     *  @return string|array
     */
    public function getStatusLabel($status = false)
    {
            $statusLabel = [
                self::STATUS_NEW => 'New',
                self::STATUS_PUBLISHED => 'Published',
                self::STATUS_DRAFT => 'draft'
            ];
        return $status ? ArrayHelper::getValue($statusLabel,$this->status) : $statusLabel;
    }
    
    /**
     *  get full name column with table name or not if not set tableName
     *  @param string $attribute
     *  @param string $tableName 
     *  @return string
     */
    public static function getColumn($attribute,$tableName = null)
    {
        return is_null($tableName) ? self::tableName() .'.'.$attribute : $tableName. '.' .$attribute;
    }
    /**
     *  Quote Table Name will be replace pattern table prefix in tableName when use table name with prefix
     *  @param string $pattern if not set default '/{|{{|%|}|}}/'
     *  @return string 
     */
    public static function getQuoteTableName($string = '',$pattern = '/{|{{|%|}|}}/')
    {
        return preg_match($pattern,self::tableName()) ? preg_replace($pattern,$string,self::tableName()) : self::tableName() ;
    }
}
