<?php

declare(strict_types=1);

namespace App\Services\Api\Category;

use App\Models\Category;
use App\Models\CategorySample;
use App\Param;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Category\Dto\CategoryDto;

/**
 * Class CategoriesService
 * @package App\Services\Api
 */
final class CategoriesService extends AbstractApiService
{
    public static function getCategory(): array
    {
        $models = Category::find()
            ->where(['status' => Category::STATUS_APPROVE])
            ->asArray()
            ->all();

        if ($models === []) {
            return [];
        }

        $dataByGroupCat = CategorySample::find()
            ->select(['COUNT(id) AS count', 'categoryId'])
            ->groupBy('categoryId')
            ->asArray()
            ->indexBy('categoryId')
            ->all();

        $objects = [];

        foreach ($models as $k => $model) {
            $objects[$k] = (CategoryDto::createFromArray($model))->printArray();
            if (isset($dataByGroupCat[(int)$model['id']])) {
                $objects[$k]['countSample'] = $dataByGroupCat[(int)$model['id']]['count'];
            }
        }

        return $objects;
    }

    public function getSampleByCategory(): array
    {
        $categoriesCat = Category::find()
            ->select('id')
            ->where(['status' => Category::STATUS_APPROVE])
            ->asArray()
            ->indexBy('id')
            ->column();

        $query = CategorySample::find()
            ->select(['COUNT(id) AS count', 'categoryId'])
            ->groupBy('categoryId')
            ->indexBy('categoryId')
            ->asArray();

        $catsIds = $this->request->getInt(Param::CATEGORY_ID) ? [$this->request->getInt(Param::CATEGORY_ID)] : $categoriesCat;

        if ($catsIds === []){
            return [];
        }

        $query->andWhere(['categoryId' => $catsIds]);

        $data  = $query->all();
        $names = $this->getCategoryName($catsIds);

        if ($data === []) {
            return [];
        }

        $res = [];

        foreach ($catsIds as $categoryId) {
            $name = isset($names[$categoryId]) ? $names[$categoryId]['name'] : 'Unknown';
            $item = [
                'name'  => $name,
                'count' => isset($data[$categoryId]) ? (int)$data[$categoryId]['count'] : 0,
                'id'    => (int)$categoryId,
            ];

            $res[] = $item;
        }

        return $res;
    }

    private function getCategoryName(array $categoryIds): array
    {
        return Category::find()
            ->select(['name', 'id'])
            ->where(['id' => $categoryIds])
            ->indexBy('id')
            ->asArray()
            ->all();
    }
}
