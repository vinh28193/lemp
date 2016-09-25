<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\queries\CategoryQuery;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $parent
 * @property Category[] $categories
 */
class Category extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ],
            'slug' =>[
                'class'=>SluggableBehavior::className(),
                'attribute'=> 'title',
                'ensureUnique' => true
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\queries\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['slug'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'parent_id' => Yii::t('app', 'Parent ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     *  get status label
     *  @param bool $status default false if not set.
     *  @return string|array
     */
    public function getStatusLabels($status = false)
    {
            $statusLabel = [
                self::STATUS_INACTIVE => 'Inactive',
                self::STATUS_ACTIVE => 'Active'
            ];
        return $status ? ArrayHelper::getValue($statusLabel,$this->status) : $statusLabel;
    }
    public function getSelect2Data(){
        return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
