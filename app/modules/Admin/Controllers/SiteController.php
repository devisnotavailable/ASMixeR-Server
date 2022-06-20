<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\App;
use App\Cache\Redis;
use App\Controllers\AdminController;
use App\Models\User;

/**
 * Class SiteController
 * @package Admin\Controllers
 */
final class SiteController extends AdminController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $this->title = 'Dashboard';

        return $this->render('index');
    }
}
