<?php

declare(strict_types=1);

namespace App\Assets\Packages;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class AjaxSelect2Assets
 * @package App\Assets\Packages
 */
class AjaxSelect2Assets extends AssetBundle
{
    /**@var string $sourcePath */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/select2/dist';

    /**@var array $css */
    public $css = [
        'css/select2.css'
    ];

    /**@var array $js */
    public $js = [
        'js/select2.full.js',
        '/js/select2.js',
        '/js/optimize.js',
    ];

    /**@var array $depends */
    public $depends = [
        JqueryAsset::class,
    ];
}
