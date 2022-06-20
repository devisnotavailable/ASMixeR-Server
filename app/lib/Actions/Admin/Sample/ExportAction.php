<?php

declare(strict_types=1);

namespace App\Actions\Admin\Sample;

use App\Actions\BaseAction;
use App\Helper\Url;
use App\Services\Admin\Export\Sample\ExportSampleService;

/**
 * Class ExportSampleAction
 * @package App\Actions\Admin\Sample
 */
class ExportAction extends BaseAction
{
    public function run(): void
    {
        $service = new ExportSampleService();
        $json = $service->getJson();

        if ($json === '') {
            $this->setFlash('danger', 'not found samples');
            $this->getResponse()->redirect(Url::toRoute(['sample/index']));
        }

        $path = $service->getPathToSave();

        file_put_contents($path, $json);

        $this->getResponse()->sendFile($path);

        $this->setFlash('success', 'Done');
    }
}
