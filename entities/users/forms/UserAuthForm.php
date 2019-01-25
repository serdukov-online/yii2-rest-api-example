<?php

namespace app\entities\users\forms;


use yii\base\Model;

class UserAuthForm extends Model
{
    /**
     * @var string Username
     */
    public $username;
    /**
     * @var string Password
     */
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required']
        ];
    }
}