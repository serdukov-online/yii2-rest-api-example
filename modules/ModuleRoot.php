<?php

namespace app\modules;


use yii\base\Module;
use yii\web\Response;

class ModuleRoot extends Module
{
    public function init()
    {
        parent::init();

        // Обрабатываем ошибки
        \Yii::$app->errorHandler->errorAction = $this->id .'/default/error';

        // Отключаем поддержку сессий
        \Yii::$app->user->enableSession = false;

        // Событие на изменение вывода
        \Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function ($event)
        {
            $response = $event->sender;

            if($response->format == 'raw')
            {
                $response->format = Response::FORMAT_JSON;
                return true;
            }

            $responseData = $response->data;

            if(is_string($responseData) && json_decode($responseData))
            {
                $responseData = json_decode($responseData, true);
            }

            if($response->statusCode >= 200 && $response->statusCode <= 299)
            {
                $response->data = [
                    'success'   => true,
                    'status'    => $response->statusCode,
                    'data'      => $responseData,
                ];
            } else {
                $response->data = [
                    'success'   => false,
                    'status'    => $response->statusCode,
                    'data'      => $responseData,
                ];
            }
        });
    }
}