<?php

declare(strict_types=1);

namespace App\Assets;

use App\Assets\Packages\AwesomeAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class MainAsset
 * @package App\Assets
 */
class MainAsset extends AssetBundle
{
    /**@var string $basePath */
    public $basePath = '@webroot';

    /**@var string $baseUrl */
    public $baseUrl = '@web';

    /**@var array $css */
    public $css = [
        'css/site.css',
        'css/admin.css',
        'css/custom.css',
    ];

    /**@var array $depends */
    public $depends = [
        AwesomeAsset::class,
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}
