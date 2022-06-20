<?php

declare(strict_types=1);

namespace App\Modules;

/**
 * Class AdminModule
 * @package App\Modules
 */
class AdminModule extends Module
{
    public function init(): void
    {
        parent::init();

        $this->params = [
            'layout_color' => 'green',
            'module_menu'  => [
                'options' => [
                    'class' => 'sidebar-menu',
                ],
                'items'   => [
                    ['label' => 'Dashboard', 'icon' => 'fa fa-university', 'url' => ['site/index']],
                    [
                        'label' => 'Users',
                        'icon'  => 'fa fa-users',
                        'url'   => '#',
                        'items' => [
                            ['label' => 'List users', 'icon' => 'fa fa-users', 'url' => ['user/']],
                            ['label' => 'Create user', 'icon' => 'fa fa-user-plus', 'url' => ['user/create']],
                        ],
                    ],
                    ['label' => 'Profile', 'icon' => 'fa fa-user', 'url' => ['profile/index']],
                    ['label' => 'Category', 'icon' => 'fa fa-university', 'url' => ['category/index']],
                    ['label' => 'Sample', 'icon' => 'fa fa-university', 'url' => ['sample/index']],
                    ['label' => 'Feedbacks', 'icon' => 'fa fa-university', 'url' => ['feedback/index']],
                ],
            ],
        ];
    }
}
