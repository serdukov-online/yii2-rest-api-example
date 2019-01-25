<?php

namespace app\modules\v1\controllers;


use app\entities\users\forms\UserAuthForm;
use app\modules\v1\RestController;
use app\services\auth\AuthService;

class UserController extends RestController
{
    private $authService;

    /**
     * @inheritdoc
     */
    public function __construct($id, $module, AuthService $authService, array $config = [])
    {
        $this->authService = $authService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::ruleBehaviors([
            'verbs'  => [
                'auth' => ['post']
            ],
            'cors' => [
                'methods' => ['POST']
            ],
            'except' => ['auth']
        ]);

        return $behaviors;
    }

    /**
     * Авторизация по логину/паролю
     * @return array
     */
    public function actionAuth()
    {
        // Задаем модель формы для авторизации по логину/паролю
        $model = new UserAuthForm();

        if ($model->load(\Yii::$app->request->post(), 'auth')) {
            // Получаем модель пользователя
            if ($user = $this->authService->authForm($model)) {
                // Выводим на экран
                return [
                    'jwt'   => $user->jwt,
                    'name'  => $user->name
                ];
            }
        }

        \Yii::$app->response->statusCode = 401;

        return [];
    }
}