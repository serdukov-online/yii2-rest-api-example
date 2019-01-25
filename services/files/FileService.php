<?php

namespace app\services\files;


use app\entities\files\Files;
use app\repositories\files\FileRepository;

class FileService
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    /**
     * Сохраняем файл
     * @param int $user_id
     * @param string $content
     * @param string $name
     * @param string $type
     * @param int $size
     * @return Files
     */
    public function create(int $user_id, string $content, string $name, string $type, int $size)
    {
        return $this->fileRepository->save(Files::create($user_id, $content, $name, $type, $size));
    }

    /**
     * Получаем модель файла
     * - по UUID
     * @param string $uuid
     * @return Files|null
     */
    public function getFileByUUID(string $uuid)
    {
        return $this->fileRepository->getByUUID($uuid);
    }
}