<?php

declare(strict_types=1);

namespace App\Services\Api\Sample;

use App\App;
use App\Exceptions\Api\ApiException;
use App\Exceptions\Api\InvalidateParam;
use App\Models\Category;
use App\Models\CategorySample;
use App\Models\Sample;
use App\Param;
use App\Services\Api\Sample\Dto\SampleDto;

final class GetSampleService extends BaseSampleService
{
    private int $categoryId = 0;

    public function getAll(): array
    {
        $sql = "SELECT sampleId FROM ". CategorySample::tableName().
            " WHERE categoryId IN(SELECT id FROM "
            . Category::tableName()." WHERE status = '".Category::STATUS_APPROVE."')";

        $sampleIdsWithApproveCats = App::i()->getDb()->createCommand($sql)->queryColumn();

        $models = Sample::find()
            ->where(['status' => Sample::STATUS_APPROVE])
            ->andWhere(['id' => $sampleIdsWithApproveCats])
            ->asArray()
            ->all();

        if ($models === []) {
            return [];
        }

        return $this->treatmentSamples($models);
    }

    public function getSampleByCategory(): array
    {
        $this->validateParam();

        $ids = CategorySample::find()
            ->select(['sampleId'])
            ->where(['categoryId' => $this->categoryId])
            ->column();

        $models = Sample::find()
            ->where(['status' => Sample::STATUS_APPROVE])
            ->andWhere(['id' => array_values($ids)])
            ->asArray()
            ->all();

        if ($models === []) {
            return [];
        }

        $catIdsBySample = CategorySample::find()
            ->select(['categoryId', 'sampleId'])
            ->where(['sampleId' => array_values($ids)])
            ->asArray()
            ->all();

        $format = [];

        foreach ($catIdsBySample as $item) {
            $format[(int)$item['sampleId']][] = $item['categoryId'];
        }

        $array = $this->treatmentSamples($models);

        foreach ($array as $k => $item) {
            $array[$k]['categories'] = $format[$item['id']];
        }

        return $array;
    }

    protected function validateParam(): void
    {
        $categoryId = $this->request->getInt(Param::CATEGORY_ID);

        if (!$categoryId) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'invalid param ' . Param::CATEGORY_ID);
        }

        $category = Category::findOne($categoryId);

        if (!$category) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'invalid param ' . Param::CATEGORY_ID);
        }

        if ($category->status !== Category::STATUS_APPROVE) {
            throw new InvalidateParam(ApiException::CODE_IS_NOT_APPROVE, 'Category is not approve');
        }

        $this->categoryId = $categoryId;
    }

    /**
     * @param array $samples
     *
     * @return array
     */
    private function treatmentSamples(array $samples): array
    {
        $objects = [];
        foreach ($samples as $model) {
            $objects[] = (SampleDto::createFromArray($model))->printArray();
        }

        return $objects;
    }
}
