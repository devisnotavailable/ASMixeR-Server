<?php

declare(strict_types=1);

namespace App\Assets;

use App\App;
use App\Assets\Packages\AjaxSelect2Assets;
use App\Assets\Packages\AwesomeAsset;
use App\Assets\Packages\BootstrapDatepickerAsset;
use App\Assets\Packages\ChosenAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class AdminAsset
 * @package App\Assets
 */
class AdminAsset extends AssetBundle
{
    /**@var  string $basePath */
    public $basePath = '@webroot';

    /**@var string $baseUrl */
    public $baseUrl = '@web';

    /**@var array $css */
    public $css = [
        'css/admin.css',
        'css/custom.css',
    ];

    /**@var array $js */
    public $js = [
        'js/app.min.js',
        'js/lib.js',
    ];

    /**@var array $depends */
    public $depends = [
        AwesomeAsset::class,
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
        ChosenAsset::class,
        BootstrapDatepickerAsset::class,
        AjaxSelect2Assets::class,
    ];

    public function init()
    {
        parent::init();
        $this->css[] = 'css/skins/skin-' . App::i()->getCurrentModule()->params['layout_color'] . '.min.css';
    }
}
