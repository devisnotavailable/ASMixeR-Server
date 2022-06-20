<?php

namespace App\Services\Admin\Export\Category;

use App\App;
use App\Models\Category;
use App\Services\Admin\Export\ExportServiceInterface;

class ExportCategoryService implements ExportServiceInterface
{
    private const FILE_NAME_CONSTANT = 'export_category.json';

    public function getFileName(): string
    {
        return self::FILE_NAME_CONSTANT;
    }

    public function getJson(): string
    {
        $categories = $this->getCategories();

        if ($categories === []) {
            return '';
        }

        $all = [];

        foreach ($categories as $item) {
            $all[] = (CategoryDto::createFromArray($item))->printArray();
        }

        return json_encode($all);
    }

    public function getCategories(): array
    {
        return Category::find()
            ->asArray()
            ->all();
    }

    public function getPathToSave(): string
    {
        return App::i()->getPathWeb() . '/load/' . $this->getFileName();
    }
}
