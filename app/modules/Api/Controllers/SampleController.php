<?php

declare(strict_types=1);

namespace Api\Controllers;

use App\Controllers\ApiControllers;
use App\Exceptions\Api\ApiException;
use App\Services\Api\Sample\DownloadSampleService;
use App\Services\Api\Sample\GetSampleService;

/**
 * Class SampleController
 * @package Api\Controllers
 */
final class SampleController extends ApiControllers
{
    /**
     * @return void
     * @throws ApiException
     * @api {GET} /sample/get-file
     *
     */
    public function actionGetFile(): void
    {
        $service = new DownloadSampleService($this->getRequest());

        try {
            $service->run();
        } catch (\Throwable $exception) {
            throw new ApiException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @return array
     * @throws ApiException
     * @api {GET} /sample/get
     *
     */
    public function actionGet(): array
    {
        $service = new GetSampleService($this->getRequest());

        try {
            $samples = $service->getSampleByCategory();
        } catch (\Throwable $exception) {
            throw new ApiException($exception->getCode(), $exception->getMessage());
        }

        return ['samples' => $samples];
    }

    /**
     * Only approve status
     * @return array
     * @throws ApiException
     * @api {GET} /sample/get-all
     *
     */
    public function actionGetAll(): array
    {
        $service = new GetSampleService($this->getRequest());

        try {
            $samples = $service->getAll();
        } catch (\Throwable $exception) {
            throw new ApiException($exception->getCode(), $exception->getMessage());
        }

        return ['samples' => $samples];
    }

    protected function verbs(): array
    {
        return [
            'get-file' => ['GET',],
            'get'      => ['GET',],
            'get-all'  => ['GET',],
        ];
    }
}
