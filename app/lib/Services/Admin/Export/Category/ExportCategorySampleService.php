<?php

namespace App\Services\Admin\Export\Category;

use App\App;
use App\Models\CategorySample;
use App\Services\Admin\Export\ExportServiceInterface;

class ExportCategorySampleService implements ExportServiceInterface
{
    private const FILE_NAME_CONSTANT = 'export_category_sample.json';

    public function getFileName(): string
    {
        return self::FILE_NAME_CONSTANT;
    }

    public function getJson(): string
    {
        $data = $this->getCategorySample();

        if ($data === []) {
            return '';
        }

        return json_encode($data);
    }

    public function getPathToSave(): string
    {
       return App::i()->getPathWeb() . '/load/' . $this->getFileName();
    }

    public function getCategorySample(): array
    {
        return CategorySample::find()
            ->asArray()
            ->all();
    }
}
