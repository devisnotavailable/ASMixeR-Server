<?php

declare(strict_types=1);

namespace Api\Controllers;

use App\Components\Upload\UploadSample;
use App\Controllers\ApiControllers;
use App\Exceptions\Api\ApiException;
use App\Helper\Tool;
use App\Services\Api\Category\CategoriesService;
use App\Services\Api\Sample\AddSampleService;

/**
 * Class LibController
 * @package Api\Controllers
 */
final class LibController extends ApiControllers
{
    /**
     * @return \string[][]
     */
    protected function verbs(): array
    {
        return [
            'categories' => ['GET'],
        ];
    }

    /**
     * @return \string[][]
     * @api {GET} /lib/categories
     */
    public function actionCategories(): array
    {
        $cats = CategoriesService::getCategory();
        return ['cats' => $cats];
    }

    /**
     * @return string[]
     * @api {GET} /lib/sample-count-by-category
     *
     */
    public function actionSampleCountByCategory(): array
    {
        return (new CategoriesService($this->getRequest()))->getSampleByCategory();
    }

    /**
     * @return int[]
     * @throws \yii\db\Exception
     * @throws ApiException
     * @api {POST} /lib/add-sample
     *
     */
    public function actionAddSample(): array
    {
        $service = new AddSampleService($this->getRequest());
        $sample  = new UploadSample();

        try {
            $rs = $service->add($sample);
        } catch (\Exception $exception) {
            throw new ApiException(400, $exception->getMessage());
        }

        return ['status' => Tool::boolToText($rs)];
    }

    /**
     * @return string[]
     * @api {POST} /lib/categories-updates
     *
     */
    public function actionCategoriesUpdates(): array
    {
        return ['CategoriesUpdate' => 'ok'];
    }

    /**
     * @return string[]
     * @api {POST} /lib/sample-updates
     *
     */
    public function actionSamplesUpdates(): array
    {
        return ['SamplesUpdates' => 'ok'];
    }
}
