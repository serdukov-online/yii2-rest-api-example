<?php

namespace app\modules\v1\controllers;


use app\modules\v1\RestController;

class DefaultController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return parent::ruleBehaviors([
            'except' => ['index', 'error', 'options']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        return 'Api ;)';
    }

    /**
     * @inheritdoc
     */
    public function actionError()
    {
        \Yii::$app->response->statusCode = 400;
        return 'Bad Request';
    }

    /**
     * @inheritdoc
     */
    public function actionOptions()
    {
        return 'ok';
    }
}