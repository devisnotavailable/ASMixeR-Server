<?php

declare(strict_types=1);

namespace Console\Controllers;

use App\Controllers\ConsoleController;
use App\Models\User;
use App\RBAC\RbacHelper;
use App\RBAC\UserRule;
use yii\helpers\Console;
use yii\rbac\DbManager;

/**
 * Class RbacController
 * @package Console\Controllers
 */
final class RbacController extends ConsoleController
{
    /**
     * @command ./yii rbac/init
     *
     * @throws \Exception
     */
    public function actionInit(): void
    {
        /**@var DbManager $auth */
        $auth = \Yii::$app->getAuthManager();
        $auth->removeAll();

        $rule = new UserRule();
        $auth->add($rule);

        $admin              = $auth->createRole(User::TYPE_ADMIN);
        $admin->description = 'Admin';
        $admin->ruleName    = $rule->name;
        $auth->add($admin);

        $default_user              = $auth->createRole(User::TYPE_DEFAULT_USER);
        $default_user->description = 'Default user';
        $default_user->ruleName    = $rule->name;
        $auth->add($default_user);

        foreach (RbacHelper::getRules() as $rules_block) {
            foreach ($rules_block as $item => $description) {
                $item              = $auth->createPermission($item);
                $item->description = $description;
                $auth->add($item);

                $permission = $auth->getPermission($item->name);
                $auth->assign($permission, User::DEFAULT_ADMIN_ID);
            }
        }

        $this->stdout("Done.\n", Console::FG_GREEN, Console::BOLD);
    }

    public function actionRemove(): void
    {
        /**@var DbManager $auth */
        $auth = \Yii::$app->getAuthManager();
        $auth->removeAll();

        $this->stdout("Done.\n", Console::FG_GREEN, Console::BOLD);
    }
}
