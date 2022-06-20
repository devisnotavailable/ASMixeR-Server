<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\Controllers\AdminController;
use App\Forms\User\LoginForm;
use App\Helper\Url;

/**
 * Class AuthController
 * @package Admin\Controllers
 */
final class AuthController extends AdminController
{
    public $layout = 'auth';

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionLogin()
    {
        $this->title = 'Login';

        if ($this->getCurrentUser()) {
            return $this->redirect(Url::toRoute(['site/index']));
        }

        $model = new LoginForm();

        if ($this->getRequest()->isPost() && $model->load($this->getRequest()->post()) && $model->login()) {
            return $this->redirect(Url::toRoute(['site/index']));
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout(): \yii\web\Response
    {
        $this->logout();

        return $this->redirect('/');
    }
}
