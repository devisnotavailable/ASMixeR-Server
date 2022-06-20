<?php

declare(strict_types=1);

namespace App\RBAC;

use App\Models\User;
use yii\rbac\DbManager;

/**
 * Class RbacManager
 * @package App\RBAC
 */
class RbacManager extends DbManager
{
    /**@var array $defaultRoles */
    public $defaultRoles = [
        User::TYPE_ADMIN,
        User::TYPE_DEFAULT_USER,
    ];
}
