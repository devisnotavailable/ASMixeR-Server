<?php

namespace App\Services\Admin\Export\Sample;

use App\App;
use App\Models\Sample;
use App\Services\Admin\Export\ExportServiceInterface;

class ExportSampleService implements ExportServiceInterface
{
    private const FILE_NAME_CONSTANT = 'export_sample.json';

    public function getFileName(): string
    {
        return self::FILE_NAME_CONSTANT;
    }

    public function getJson(): string
    {
        $samples = $this->getSamples();

        if ($samples === []) {
            return '';
        }

        $all = [];

        foreach ($samples as $item) {
            $all[] = (SampleDto::createFromArray($item))->printArray();
        }

        return json_encode($all);
    }

    public function getPathToSave(): string
    {
        return App::i()->getPathWeb() . '/load/' . $this->getFileName();
    }

    public function getSamples(): array
    {
        return Sample::find()
            ->asArray()
            ->all();
    }
}
