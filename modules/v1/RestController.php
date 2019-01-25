<?php

namespace app\modules\v1;


use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;

abstract class RestController extends Controller
{
    /**
     * @param array array[verbs]
     *              array[cors][methods]
     *              array[cors][headers]
     *              array[except]
     * @return array
     */
    public function ruleBehaviors(array $array = [])
    {
        $behaviors = parent::behaviors();

        // array actions
        $verbs = $array['verbs'] ?? [];

        // add verbs filter
        $behaviors['verbs'] = [
            'class'     => VerbFilter::class,
            'actions'   => $verbs
        ];

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method'     => $array['cors']['methods'] ?? ['GET', 'DELETE'],
                'Access-Control-Request-Headers'    => ['*'],
                'Access-Control-Allow-Credentials'  => true,
                'Access-Control-Expose-Headers'     => $array['cors']['headers'] ?? []
            ]
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class
            ]
        ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = $array['except'] ?? [];

        // setup access
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only'  => array_keys($verbs),
            'rules' => [
                [
                    'allow'     => true,
                    'actions'   => array_keys($verbs)
                ]
            ]
        ];

        return $behaviors;
    }
}