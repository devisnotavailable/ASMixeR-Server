<?php

declare(strict_types=1);

namespace App\Services\Api\Sample;

use App\Components\Download\DownloadService;
use App\Exceptions\Api\ApiException;
use App\Exceptions\Api\DbException;
use App\Exceptions\Api\InvalidateParam;
use App\Models\Sample;
use App\Param;

/**
 * Class DownloadSampleService
 * @package App\Services\Api\Sample
 */
final class DownloadSampleService extends BaseSampleService
{
    private ?string $sampleUuid = null;

    /**
     * @return void
     * @throws DbException
     * @throws InvalidateParam
     */
    public function run(): void
    {
        $this->validateParam();
        $sample = $this->getSampleModel();

        header("Content-Type: application/jpeg");
        header("Content-Length: " . filesize($sample->path));
        header('Content-Disposition: attachment; filename="' . $sample->name . '"');

        readfile($sample->path);
    }

    /**
     * @return void
     * @throws InvalidateParam
     */
    protected function validateParam(): void
    {
        $sampleUuid = $this->request->getStr(Param::UUID);

        if (!$sampleUuid) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'invalid param uuid');
        }

        $this->sampleUuid = $sampleUuid;
    }

    /**
     * @return Sample
     * @throws DbException
     */
    private function getSampleModel(): Sample
    {
        $model = Sample::findOne(['uuid' => $this->sampleUuid]);

        if (!$model) {
            throw new DbException(ApiException::CODE_NOT_FOUND, 'not found sample');
        }

        return $model;
    }
}
