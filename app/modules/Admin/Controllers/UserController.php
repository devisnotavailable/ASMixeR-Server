<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\Controllers\AdminController;
use App\Forms\Admin\User\CreateUserForm;
use App\Forms\Admin\User\UserProfileForm;
use App\Helper\Html;
use App\Helper\Url;
use App\Models\User;
use App\Param;

/**
 * Class UserController
 * @package Admin\Controllers
 */
final class UserController extends AdminController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $this->title = ' List users';

        $users = User::find()
            ->all();

        return $this->render('index', [
            'users' => $users,
        ]);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionCreate(): string
    {
        $this->title = "Create new user";

        $model = new CreateUserForm(new User());

        if ($this->getRequest()->isPost() && $model->load($this->getRequest()->post()) && $model->save()) {
            $this->setFlash('success', "Successfully created user");
            $this->redirect(Url::toRoute(['user/index']));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\web\HttpException
     */
    public function actionEdit()
    {
        $id = $this->getRequest()->getInt(Param::ID);

        if (!$id) {
            $this->getResponse()->set404();
        }

        $user = User::findOne($id);

        if (!$user) {
            $this->getResponse()->set404();
        }

        $this->title = 'Edit: ' . Html::encode($user->username) . ' [' . $user->id . ']';

        $model = new UserProfileForm($user);

        if ($this->getRequest()->isPost() && $model->load($this->getRequest()->post()) && $model->save()) {
            $this->setFlash('success', "Successfully edited user");

            $this->redirect(Url::toRoute(['user/index']));
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * @return array
     * @throws \yii\web\HttpException
     */
    public function actionChangeStatus(): array
    {
        if (!$this->getRequest()->isAjax() || !$this->getRequest()->isPost()) {
            $this->getResponse()->set404();
        }

        $id = $this->getRequest()->postInt(Param::ID);

        if (!$id) {
            $this->getResponse()->set404();
        }

        $user = User::findOne($id);

        if (!$user) {
            $this->getResponse()->set404();
        }

        if (($user->isActive()) && $user->banned()) {
            return ['success' => 1];
        }

        if ($user->unbanned()) {
            return ['success' => 1];
        }

        return ['error' => 1];
    }

    /**
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionPermission(): string
    {
        $manager_id = $this->getRequest()->getInt(Param::ID);
        $manager    = User::findOne(['id' => $manager_id]);

        if (!$manager) {
            $this->getResponse()->set404();
        }

        $auth_manager        = \Yii::$app->getAuthManager();
        $manager_permissions = $auth_manager->getPermissionsByUser($manager_id);

        if ($this->getRequest()->isPost()) {
            $auth_manager->revokeAll($manager->id);
            $permissions = $this->getRequest()->postArray('permissions', []);

            foreach ($permissions as $permission => $check) {
                if (!$permission) {
                    continue;
                }
                if ($permission = $auth_manager->getPermission($permission)) {
                    $auth_manager->assign($permission, $manager_id);
                }

                $manager_permissions = $auth_manager->getPermissionsByUser($manager_id);
            }
        }

        return $this->render('permission', [
            'manager_permissions' => $manager_permissions,
        ]);
    }
}
