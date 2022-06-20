<?php

declare(strict_types=1);

namespace App\RBAC;

use App\App;
use App\Models\User;
use yii\rbac\Rule;

/**
 * Class UserRule
 * @package App\RBAC
 */
class UserRule extends Rule
{
    public $name = 'userRole';

    /**
     * @param int|string     $user
     * @param \yii\rbac\Item $item
     * @param array          $params
     *
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        if (!App::i()->isGuest()) {
            $type = App::i()->getCurrentUser()->type;
            if ($item->name == User::TYPE_ADMIN) {
                return $type == User::TYPE_ADMIN;
            }

            if ($item->name == User::TYPE_DEFAULT_USER) {
                return $type == User::TYPE_DEFAULT_USER;
            }
        }

        return false;
    }
}
