<?php

$config = [
    'id' => 'asmixer-main',
    'language' => 'en-EN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerNamespace' => 'Main\Controllers',
    'viewPath' => '@Main/views',
    'modules' => [
        'admin' => [
            'class' => \App\Modules\AdminModule::class,
            'controllerNamespace' => 'Admin\Controllers',
            'viewPath' => '@Admin/views'
        ],
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                yii\web\JqueryAsset::class => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD]
                ],
                yii\bootstrap\BootstrapPluginAsset::class => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD]
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'MWz-W4b5sOiRo6Oqv0W-5oms55hx-tof',
        ],
        'user' => [
            'identityClass' => \App\Models\User::class,
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'admin/login' => '/admin/auth/login',
            ],
        ],

    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
    ];
}

return $config;
