<?php
namespace common\models;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;

/** 
 * This is the model class for table "{{%user}}". 
 * 
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $oauth_client_id
 * @property string $oauth_client_secret
 * @property string $auth_key
 * @property string $access_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $scenario
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
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

    //const SCENARIO_DEFAULT = 'default';
    const SCENARIO_OAUTH_1 = 'oauth1';
    const SCENARIO_OAUTH_2 = 'oauth2';

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
            'scenario' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'scenario'
                ],
                'value' => self::SCENARIO_DEFAULT,
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
            [['username'],'filter','filter'=>'\yii\helpers\Html::encode'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [ 
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'oauth_client_id' => Yii::t('app', 'Oauth Client ID'),
            'oauth_client_secret' => Yii::t('app', 'Oauth Client Secret'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'access_token' => Yii::t('app', 'Access Token'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'scenario' => Yii::t('app', 'Scenario'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
        if (!static::isAccessTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'access_token' => $token,
            'status' => self::STATUS_ACTIVE
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
            'username' => $username, 
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds user by username or email or access token
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
                ['username' => $login], 
                ['email' => $login],
                ['access_token' => $login]
            ],
           'status' => self::STATUS_ACTIVE
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
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
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
        $expire = 3600;
        return $timestamp + $expire >= time();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isAccessTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        return true;
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
     * Generates new access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString(25) . '_' . self::SCENARIO_DEFAULT;
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
    public function getStatusLabels($status = false)
    {
            $statusLabel = [
                self::STATUS_INACTIVE => 'Inactive',
                self::STATUS_ACTIVE => 'Active'
            ];
        return $status ? ArrayHelper::getValue($statusLabel,$this->status) : $statusLabel;
    }
}