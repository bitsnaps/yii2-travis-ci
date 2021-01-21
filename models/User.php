<?php

namespace app\models;


/**
 * This is the model class for table "user".
 *
 * @property integer $id @column pk
 * @property string $username @column string(255)|unique|notNull
 * @property string $password_hash @column string(255)|notNull
 * @property string $auth_key @column string(32)|notNull
 * @property string $access_token @column string(255)|notNull
 * @property int $status
 */
class User extends \yii\db\ActiveRecord /*base\BaseObject*/ implements \yii\web\IdentityInterface
{
/*    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'access_token', 'status'], 'required'],
            [['status'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password_hash', 'auth_key', 'access_token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'username' => \Yii::t('app', 'Username'),
            'password_hash' => \Yii::t('app', 'Password'),
            'status' => \Yii::t('app', 'Status'),
            'auth_key' => \Yii::t('app', 'Auth Key'),
            'access_token' => \Yii::t('app', 'Access Token'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }*/
        $user = static::findOne(['access_token' => $token]);
        if ($user){
            return $user;
        }
        return null;

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
/*        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
*/
        $user = static::findOne(['username' => $username]);
        if ($user){
            return $user;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        // return $this->password === $password;
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                // CAUTION: this should be set and validated by sending an email to the user
                // $this->access_token = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

}
