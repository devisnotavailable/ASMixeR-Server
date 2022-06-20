<?php

declare(strict_types=1);

namespace App\Assets\Packages;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class ChosenAsset
 * @package App\Assets\Packages
 */
class ChosenAsset extends AssetBundle
{
    /**@var string $sourcePath */
    public $sourcePath = '@bower/chosen';

    /**@var array $css */
    public $css = [
        'chosen.css',
    ];

    /**@var array $js */
    public $js = [
        'chosen.jquery.js',
    ];

    /**@var array $depends */
    public $depends = [
        JqueryAsset::class
    ];
}
