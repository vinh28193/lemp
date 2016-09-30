<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\models\queries\ArticleQuery;
/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property string $body
 * @property integer $view
 * @property integer $category_id
 * @property integer $author_id
 * @property integer $updater_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $updated_at
 */
class Article extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;

    const IMAGE_TARGET = 'article';

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
        return new ArticleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'category_id', 'author_id', 'updater_id'], 'required'],
            [['description', 'body'], 'string'],
            [['view', 'category_id', 'author_id', 'updater_id', 'status', 'published_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 512],
            [['slug', 'short_description'], 'string', 'max' => 1024],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'slug' => Yii::t('app', 'Slug'),
            'short_description' => Yii::t('app', 'Short Description'),
            'description' => Yii::t('app', 'Description'),
            'body' => Yii::t('app', 'Body'),
            'view' => Yii::t('app', 'View'),
            'category_id' => Yii::t('app', 'Category ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'updater_id' => Yii::t('app', 'Updater ID'),
            'status' => Yii::t('app', 'Status'),
            'published_at' => Yii::t('app', 'Published At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
     *  get status label
     *  @param bool $status default false if not set.
     *  @return string|array
     */
    public function getStatusLabel($status = false)
    {
            $statusLabel = [
                self::STATUS_NEW => 'New',
                self::STATUS_PUBLISHED => 'Published',
                self::STATUS_DRAFT => 'Draft'
            ];
        return $status ? ArrayHelper::getValue($statusLabel,$this->status) : $statusLabel;
    }
}
