<?php

return [
    'bootstrap'  => ['log'],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'basePath'   => BASE_PATH,
    'timeZone'   => date_default_timezone_get(),
    'name'       => '',
    'components' => [
        'log'         => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'          => [
            'class'    => yii\db\Connection::class,
            'dsn'      => 'mysql:host=host;dbname=dbname',
            'username' => 'username',
            'password' => 'password',
            'charset'  => 'utf8',
        ],
        'cache'       => [
            'class'    => \App\Cache\Redis::class,
            'host'     => '127.0.0.1',
            'database' => 1,
            'password' => '',
        ],
        'authManager' => [
            'class' => \App\RBAC\RbacManager::class,
        ],
    ],
    'params'     => require(__DIR__ . '/params.php'),
];
