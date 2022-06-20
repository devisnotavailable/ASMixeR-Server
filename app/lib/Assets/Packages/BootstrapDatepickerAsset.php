<?php

declare(strict_types=1);

namespace App\Assets\Packages;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;

/**
 * Class BootstrapDatepickerAsset
 * @package App\Assets\Packages
 */
class BootstrapDatepickerAsset extends AssetBundle
{
    /**@var string $sourcePath */
    public $sourcePath = '@bower/bootstrap-datepicker/dist';

    /**@var array $css */
    public $css = [
        'css/bootstrap-datepicker.css'
    ];

    /**@var array $js */
    public $js = [
        'js/bootstrap-datepicker.js',
        'locales/bootstrap-datepicker.ru.min.js',
    ];

    /**@var array $depends */
    public $depends = [
        BootstrapPluginAsset::class
    ];
}
