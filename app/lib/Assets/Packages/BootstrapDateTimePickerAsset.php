<?php

declare(strict_types=1);

namespace App\Assets\Packages;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;

/**
 * Class BootstrapDateTimePickerAsset
 * @package App\Assets\Packages
 */
class BootstrapDateTimePickerAsset extends AssetBundle
{
    /**@var string $sourcePath */
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker/build';

    /**@var array $css */
    public $css = [
        'css/bootstrap-datetimepicker.css',
    ];

    /**@var array $js */
    public $js = [
        'js/bootstrap-datetimepicker.min.js',
    ];

    /**@var array $depends */
    public $depends = [
        BootstrapPluginAsset::class,
        MomentAsset::class
    ];
}
