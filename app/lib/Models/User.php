<?php

namespace App\Models;

use App\Base\ActiveRecord;
use App\Behavior\Timestamp;
use yii\base\Exception;
use yii\web\IdentityInterface;

/**
 * Class User
 * @property int    $id              [int(11)]
 * @property string $username        [varchar(255)]
 * @property string $hash_password   [varchar(255)]
 * @property string $auth_key        [varchar(255)]
 * @property string $access_token    [varchar(255)]
 * @property string $email           [varchar(255)]
 * @property string $phone           [varchar(11)]
 * @property int    $type            [tinyint(1)]
 * @property int    $status          [tinyint(1)]
 * @property int    $date_created    [timestamp]
 * @property int    $date_updated    [timestamp]
 * @property mixed  $hashPassword
 * @property string $authKey
 * @property int    $date_last_visit [timestamp]
 * @package App\Models
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const TYPE_ADMIN        = 1;
    public const TYPE_DEFAULT_USER = 2;

    public const STATUS_ACTIVE = 1;
    public const STATUS_BANNED = 2;

    public const DEFAULT_ADMIN_ID = 1;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            Timestamp::class,
        ];
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token, 'type' => $type]);
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
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return \Yii::$app->security->validatePassword($password, $this->hash_password);
    }

    /**
     * @param string $password
     *
     * @throws Exception
     */
    public function setHashPassword(string $password): void
    {
        $this->hash_password = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @throws Exception
     */
    public function generateAccessToken(): void
    {
        $this->access_token = \Yii::$app->security->generateRandomString(16);
    }

    /**
     * @throws Exception
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @param null $type
     *
     * @return array|mixed
     */
    public static function getTypes($type = null)
    {
        $types = [
            self::TYPE_ADMIN        => 'Admin',
            self::TYPE_DEFAULT_USER => 'User'
        ];

        return $types[$type] ?? $types;
    }

    /**
     * @return bool
     */
    public function banned(): bool
    {
        if ($this->status === self::STATUS_BANNED) {
            return true;
        }

        $this->status = self::STATUS_BANNED;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function unbanned(): bool
    {
        if ($this->status === self::STATUS_ACTIVE) {
            return true;
        }

        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
