<?php

namespace app\components;


use app\entities\users\Employment;
use app\entities\users\providers\AuthInfocomProvider;
use app\entities\users\providers\eIDProvider;
use app\entities\users\Profile;
use \app\entities\users\User as Entity;

/**
 * Class User
 * @package app\components
 *
 * @property mixed $auth
 * @property string $jwt
 */
class User extends \yii\web\User
{
    public function getAuth()
    {
        return Entity::find()
            ->where(['id' => $this->id])
            ->one();
    }

    /**
     * @return string
     */
    public function getJwt()
    {
        /* @var \app\entities\users\User $user */
        if($user = \Yii::$app->user->identity->getData())
        {
            return $user->jwt;
        }

        return false;
    }
}