<?php

namespace app\repositories\users;


use app\entities\users\User;

class UserRepository
{
    /**
     * Возвращаем модель пользователя
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username)
    {
        return $this->getBy([
            'username' => $username
        ]);
    }

    /**
     * @param User $model
     * @return User
     */
    public function save(User $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения записи');
        }

        return $model;
    }

    /**
     * @param array $conditions
     * @return User|null
     */
    private function getBy(array $conditions)
    {
        return User::find()
            ->andWhere($conditions)
            ->limit(1)
            ->one();
    }
}