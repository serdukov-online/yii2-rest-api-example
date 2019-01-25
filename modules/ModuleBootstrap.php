<?php

namespace app\modules;


use yii\base\BootstrapInterface;

class ModuleBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            // Files
            // - info
            [
                'pattern' => 'v1/file/<uuid:\\w+-\\w+-\\w+-\\w+-\\w+>/info',
                'route'   => 'v1/file/file',
                'verb'    => 'GET'
            ],
            // - get
            [
                'pattern' => 'v1/file/<uuid:\\w+-\\w+-\\w+-\\w+-\\w+>/content',
                'route'   => 'v1/file/content',
                'verb'    => 'GET'
            ],
            // - raw
            [
                'pattern' => 'v1/file/<uuid:\\w+-\\w+-\\w+-\\w+-\\w+>/raw',
                'route'   => 'v1/file/raw',
                'verb'    => 'GET'
            ],
            // Options
            [
                'pattern' => 'v1/file/<uuid:\\w+-\\w+-\\w+-\\w+-\\w+>/info|content|raw',
                'route'   => 'v1/default/options',
                'verb'    => 'OPTIONS'
            ]
        ]);
    }
}