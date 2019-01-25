<?php

namespace app\components;


use app\entities\users\Employment;
use app\entities\users\Profile;
use app\entities\users\providers\JWTProvider;
use app\entities\users\User;
use yii\web\IdentityInterface;

/**
 * Class Identity
 * @package app\components
 */
class Identity implements IdentityInterface
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Возвращаем объект `Identity` пользователя
     * @param int|string $id
     * @return User|bool
     */
    public static function findIdentity($id)
    {
        if($user = User::find()
            ->where(['id' => $id])
            ->limit(1)
            ->one())
        {
            return new static($user);
        }

        return false;
    }

    /**
     * Проверяем JWT и проверяем пользователя
     * @param mixed $token
     * @param null $type
     * @return bool|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if($user_id = JWTProvider::getUserIdByToken($token, $type))
        {
            if($user = User::find()
                ->where(['id' => $user_id])
                ->limit(1)
                ->one())
            {
                return new static($user);
            }
        }

        return false;
    }

    /**
     * Возвращаем ID пользователя
     * @return int
     */
    public function getId(): int
    {
        return $this->user->id;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Возвращаем модель пользователя
     * @return User
     */
    public function getData()
    {
        return $this->user;
    }
}