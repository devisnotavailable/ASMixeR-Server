<?php

namespace Main\Controllers;

use App\Controllers\MainController;

/**
 * Class SiteController
 * @package Main\Controllers
 */
class SiteController extends MainController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $this->title = 'Welcome';

        return $this->render('index');
    }
}