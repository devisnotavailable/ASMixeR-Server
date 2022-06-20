<?php

declare(strict_types=1);

namespace App\RBAC;

/**
 * Class RbacHelper
 * @package App\RBAC
 */
class RbacHelper
{
    public const BLOCK_USER = 1;
    public const BLOCK_TOOL = 2;

    /**
     * @param $block
     *
     * @return string|string[]
     */
    public static function getRuleBlockName($block): array|string
    {
        $block_names = [
            self::BLOCK_USER => 'Users',
            self::BLOCK_TOOL => 'Tools',
        ];

        return $block_names[$block] ?? $block_names;
    }

    /**
     * @return array
     */
    public static function getRules(): array
    {
        return [
            self::BLOCK_USER => [
                'user/index'         => 'List users',
                'user/add'           => 'Create user',
                'user/edit'          => 'Edit user',
                'user/permission'    => 'Permissions user',
                'user/change-status' => 'Change status',
            ],
            self::BLOCK_TOOL => [
                'tool/set-password' => 'Change password',
            ],
        ];
    }
}
