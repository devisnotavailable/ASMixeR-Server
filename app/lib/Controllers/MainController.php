<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Assets\MainAsset;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController extends BaseController
{
    /**@var string $layout */
    public $layout = 'main';

    /**
     * @param $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        MainAsset::register($this->view);

        return parent::beforeAction($action);
    }
}
