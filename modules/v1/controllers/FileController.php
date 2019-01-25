<?php

namespace app\modules\v1\controllers;


use app\entities\files\Files;
use app\entities\files\forms\FileUploadModel;
use app\modules\v1\RestController;
use app\services\files\FileService;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class FileController extends RestController
{
    private $fileService;

    public function __construct($id, $module, FileService $fileService, array $config = [])
    {
        $this->fileService = $fileService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::ruleBehaviors([
            'verbs'  => [
                'upload'    => ['post'],
                'file'      => ['get'],
                'content'   => ['get'],
                'raw'       => ['get']
            ],
            'cors' => [
                'methods' => ['GET', 'POST']
            ]
        ]);

        return $behaviors;
    }

    /**
     * Метод загрузки файла
     * @return Files|null
     */
    public function actionUpload()
    {
        // Задаем модель для загрузки файла
        $model = new FileUploadModel();
        $model->file = UploadedFile::getInstanceByName('file');

        if ($model->file && $model->validate())
            return $this->fileService->create(\Yii::$app->user->id, file_get_contents($model->file->tempName), substr($model->file->baseName, 0, 250), $model->file->type, $model->file->size);

        else {
            \Yii::$app->response->statusCode = 400;

            return [
                'errors' => $model->getErrors()
            ];
        }

        return null;
    }

    /**
     * Возврщаем информацию о файле
     * @param string $uuid
     * @return Files|null
     * @throws NotFoundHttpException
     */
    public function actionFile(string $uuid)
    {
        if ($file = $this->fileService->getFileByUUID($uuid))
            return $file;

        throw new NotFoundHttpException();
    }

    /**
     * Возвращаем контент документа
     * @param $uuid
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionContent($uuid)
    {
        if ($file = $this->fileService->getFileByUUID($uuid))
            return base64_encode(stream_get_contents($file->content));

        throw new NotFoundHttpException();
    }

    /**
     * Возвращаем файл для скачивания
     * @param $uuid
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRaw($uuid)
    {
        if ($file = $this->fileService->getFileByUUID($uuid)) {
            header('Content-type: '. $file->type);

            echo stream_get_contents($file->content);
            \Yii::$app->end();
        }

        throw new NotFoundHttpException();
    }
}