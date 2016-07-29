<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%image}}".
 *
 * @property integer $id
 * @property string $target
 * @property integer $target_id
 * @property integer $width
 * @property integer $height
 * @property integer $quality
 * @property string $type
 * @property integer $size
 * @property integer $is_thumbnail
 * @property integer $status
 * @property integer $created_at
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target_id', 'width', 'height', 'quality', 'size', 'is_thumbnail', 'status', 'created_at'], 'integer'],
            [['target'], 'string', 'max' => 512],
            [['type'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'target' => Yii::t('app', 'Target'),
            'target_id' => Yii::t('app', 'Target ID'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'quality' => Yii::t('app', 'Quality'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'is_thumbnail' => Yii::t('app', 'Is Thumbnail'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\queries\ImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\ImageQuery(get_called_class());
    }
}
