<?php

declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Actions\BaseAction;
use App\Services\Admin\Export\Category\ExportCategoryService;
use yii\helpers\Url;

/**
 * Class ExportCategoryAction
 * @package App\Actions\Admin\Category
 */
class ExportAction extends BaseAction
{
    public function run(): void
    {
        $service = new ExportCategoryService();

        $json = $service->getJson();

        if ($json === '') {
            $this->setFlash('danger', 'not found categories');
            $this->getResponse()->redirect(Url::toRoute(['category/index']));
        }

        $path = $service->getPathToSave();
        file_put_contents($path, $json);

        $this->getResponse()->sendFile($path);

        $this->setFlash('success', 'Done');
    }
}
