<?php

declare(strict_types=1);

namespace App\Assets\Packages;

use yii\web\AssetBundle;

/**
 * Class AwesomeAsset
 * @package App\Assets\Packages
 */
class AwesomeAsset extends AssetBundle
{
    /** @var string $sourcePath */
    public $sourcePath = '@bower/fontawesome';

    /**@var array $css */
    public $css = [
        'css/font-awesome.min.css',
    ];
}
