<?php

declare(strict_types=1);

namespace Main\Controllers;

use App\Actions\Main\Category\AddCategoryAction;
use App\Controllers\MainController;

final class CategoryController extends MainController
{
    public function actions(): array
    {
        return [
            'add' => AddCategoryAction::class,
        ];
    }
}
