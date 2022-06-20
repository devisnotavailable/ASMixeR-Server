<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Assets\AdminAsset;
use App\Models\User;
use yii\filters\AccessControl;
use yii\rbac\DbManager;

/**
 * Class AdminController
 * @package App\Controllers
 */
class AdminController extends BaseController
{
    /**@var string $layout */
    public $layout = 'main';

    /**
     * @return array|array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class'        => AccessControl::class,
                'rules'        => [
                    [
                        'allow'       => true,
                        'controllers' => ['admin/auth'],
                        'actions'     => ['login'],
                        'roles'       => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [User::TYPE_ADMIN],
                        'matchCallback' => function ($rule, $action) {
                            /**@var DbManager $auth */
                            $auth_manager = App::i()->getAuthManager();
                            $permission   = $this->id . '/' . $action->id;

                            return !($auth_manager->getPermission($permission) && !\Yii::$app->user->can($permission));
                        }
                    ],
                ],
                'denyCallback' => function () {
                    App::i()->getResponse()->set404();
                }
            ],
        ];
    }

    /**
     * @param $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        AdminAsset::register($this->view);

        return parent::beforeAction($action);
    }
}
