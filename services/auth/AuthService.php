<?php

namespace app\services\auth;


use app\entities\users\Employment;
use app\entities\users\forms\UserAuthForm;
use app\entities\users\User;
use app\repositories\users\UserRepository;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Возвращаем модель пользователя если он успещно авторизовался по логину/паролю
     * @param UserAuthForm $form
     * @return User|bool
     */
    public function authForm(UserAuthForm $form)
    {
        // Получаем модель пользователя по логину
        if ($user = $this->userRepository->findByUsername($form->username)) {
            // Проверяем, пароль
            if ($user->isPasswordHash() && $user->validatePassword($form->password))
                return $this->userRepository->save($user);
        }

        return false;
    }
}