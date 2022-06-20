<?php

declare(strict_types=1);

namespace App\Assets\Packages;

use yii\web\JqueryAsset;

/**
 * Class MomentAsset
 * @package App\Assets\Packages
 */
class MomentAsset
{
    /**@var string $sourcePath */
    public string $sourcePath = '@bower/moment';

    /**@var array $js */
    public array $js = [
        'moment.js'
    ];

    /**@var array $depends */
    public array $depends = [
        JqueryAsset::class
    ];
}
