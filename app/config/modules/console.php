<?php

return [
    'id'                  => 'asmixer-console',
    'controllerNamespace' => 'Console\Controllers',
    'controllerMap'       => [
        'migrate' => [
            'class'         => \yii\console\controllers\MigrateController::class,
            'templateFile'  => '@App/Components/Migration/migration_template.php',
            'migrationPath' => '@Console/migrations'
        ],
    ],
];
