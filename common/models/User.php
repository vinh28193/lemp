<?php
namespace common\models;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $oauth_id
 * @property string $oauth_secret
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property \common\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE= 0;
    const STATUS_ACTIVE = 1;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMINISTRATOR = 'administrator';

    const EVENT_USER_REGISTER = 'userRegister';
    const EVENT_BEFORE_LOGIN = 'beforeLogin';
    const EVENT_AFTER_SIGNUP = 'afterLogin';

    const TYPE_DEFAULT = 'default';
    const TYPE_OAUTH_1 = 'oauth1';
    const TYPE_OAUTH_2 = 'oauth2';

    const IMAGE_TARGET = 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'auth_key' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString(40)
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['username'],'filter','filter'=>'\yii\helpers\Html::encode']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' =>'Username',
            'email' =>'E-mail',
            'status' =>'Status',
            'access_token' =>'API access token',
            'created_at' =>'Created at',
            'updated_at' =>'Updated at',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id, 
            'status' => self::STATUS_ACTIVE
        ]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            self::getColumn('access_token',self::tableName()) => $token,
            self::getColumn('status',self::tableName()) => self::STATUS_ACTIVE
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            self::getColumn('username',self::tableName()) => $username, 
            self::getColumn('status',self::tableName()) => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by username or email
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return static::findOne([
            'and',
            [
                'or', 
                [self::getColumn('username',self::tableName()) => $login], 
                [self::getColumn('email',self::tableName()) => $login]
            ],
            self::getColumn('status',self::tableName()) => self::STATUS_ACTIVE
        ]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            self::getColumn('password_reset_token',self::tableName()) => $token,
            self::getColumn('status',self::tableName()) => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     *  get status label
     *  @param bool $status default false if not set.
     *  @return string|array
     */
    public function getStatusLabel($status = false)
    {
            $statusLabel = [
                self::STATUS_INACTIVE => 'Inactive',
                self::STATUS_ACTIVE => 'Active'
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
    /**
     *  get public identity when user logined
     *  @return string 
     */
    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }
        if ($this->username) {
            return $this->username;
        }
        return $this->email;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasMany(Image::className(), [
            'target'=>self::IMAGE_TARGET,
            'target_id' => 'id'
        ]);
    }
}