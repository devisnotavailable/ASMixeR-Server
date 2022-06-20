<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\App;
use App\Controllers\AdminController;
use App\Forms\User\ProfileForm;

/**
 * Class ProfileController
 * @package Admin\Controllers
 */
final class ProfileController extends AdminController
{
    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex(): string
    {
        $this->title = 'Profile';

        $model = new ProfileForm($this->getCurrentUser());
        $model->setScenario(ProfileForm::SCENARIO_WITHOUT_EDIT_PASSWORD);

        if ($model->load($this->getRequest()->post()) &&
            $model->validate() && $model->save()) {
            $this->setFlash('success', 'Success update profile');
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function actionChangePassword(): array
    {
        $form = new ProfileForm(App::i()->getCurrentUser());
        $form->setScenario(ProfileForm::SCENARIO_EDIT_PASSWORD);

        $data = ['success' => 0, 'errors' => []];

        if (App::i()->getRequest()->isPost()) {
            $form->password            = $this->getRequest()->postStr('password');
            $form->new_password        = $this->getRequest()->postStr('new_password');
            $form->repeat_new_password = $this->getRequest()->postStr('repeat_new_password');

            if ($form->save()) {
                $data['success'] = 1;
            } else {
                $data['errors'] = $form->getErrors();
            }
        }

        return $data;
    }
}
