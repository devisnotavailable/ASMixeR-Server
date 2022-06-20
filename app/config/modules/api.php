<?php

return [
    'id'                  => 'asmixer-api',
    'controllerNamespace' => 'Api\Controllers',
    'defaultRoute'        => 'help',
    'components'          => [
        'user'         => [
            'identityClass' => \App\Models\User::class,
            'enableSession' => false,
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
        'errorHandler' => [
            'class' => \App\Components\Api\ApiErrorHandler::class,
        ],
        'response'     => [
            'format' => 'json',
        ],
        'request'      => [
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            'parsers'                => [
                'application/json' => yii\web\JsonParser::class,
            ],
        ],
    ],
    'params' => [
        'apiDomain' => 'http://asmixer-api.loc',
    ],
];
