<?php

namespace app\entities\files\forms;


use yii\base\Model;
use yii\web\UploadedFile;

class FileUploadModel extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf, docx, xlsx', 'maxSize' => 1024 * 1024 * 340]
        ];
    }
}