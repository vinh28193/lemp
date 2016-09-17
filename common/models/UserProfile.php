<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property string $locale
 * @property integer $gender
 * @property string $address1
 * @property string $address2
 * @property string $phone
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['locale'], 'required'],
            [['gender'], 'in', 'range'=>[NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
            [['firstname', 'middlename', 'lastname', 'avatar_path', 'avatar_base_url', 'address1', 'address2'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            //['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
            [['phone'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'avatar_path' => 'Avatar Path',
            'avatar_base_url' => 'Avatar Base Url',
            'locale' => 'Locale',
            'gender' => 'Gender',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'phone' => 'Phone',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
    * get full name of user
    * @return mixed
    */
    public function getFullName()
    {
        return ($this->firstname || $this->lastname) ? implode(' ', [$this->firstname, $this->lastname]) : null;
    }

    /**
    * get avatar of user
    * @return string
    */
    public function getAvatar($default = null)
    {
        return $this->avatar_path ? Yii::getAlias(implode('/',[$this->avatar_base_url, $this->avatar_path])) : $default;
    }

    /**
     *  get sender label
     *  @param bool $sender default false if not set.
     *  @return string|array
     */
    public function getGenderLabel($gender = false)
    {
            $genderLabel = [
                self::GENDER_MALE => 'Male',
                self::GENDER_FEMALE => 'Female',
            ];
        return $gender ? ArrayHelper::getValue($genderLabel,$this->gender) : $genderLabel;
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->session->setFlash('forceUpdateLocale');
    }

}