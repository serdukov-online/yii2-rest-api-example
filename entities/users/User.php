<?php

namespace app\entities\users;


use app\entities\SoftDelete;
use app\entities\users\providers\JWTProvider;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class User
 * @package app\entities\users
 * @property string $id [integer]
 * @property string $name [varchar(255)]
 * @property string $username [varchar(32)]
 * @property string $password_hash [varchar(64)]
 * @property string $created_at [integer]
 * @property string $jwt
 * @property string $updated_at [integer]
 */
class User extends ActiveRecord
{
    /**
     * Возвращаем JWT токен
     * @return string
     */
    public function getJwt()
    {
        return JWTProvider::getJWT($this->id, $this->name);
    }

    /**
     * Проверяем хэш пароля
     * @return bool
     */
    public function isPasswordHash(): bool
    {
        return $this->password_hash !== null;
    }

    /**
     * Провереям пароль
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth}}';
    }
}