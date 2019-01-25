<?php

namespace app\repositories\files;


use app\entities\files\Files;

class FileRepository
{
    /**
     * Возвращаем модель файла
     * @param string $uuid
     * @return Files|null
     */
    public function getByUUID(string $uuid)
    {
        return $this->getBy(['uuid' => $uuid]);
    }

    /**
     * @param Files $model
     * @return Files
     */
    public function save(Files $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения записи');
        }

        return $model;
    }

    /**
     * @param array $conditions
     * @return Files|null
     */
    private function getBy(array $conditions)
    {
        return Files::find()
            ->where($conditions)
            ->limit(1)
            ->one();
    }
}