<?php

namespace App\Models;

use App\Base\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Class CategorySample
 * @package App\Models
 * @property int           $id         [int(11)]
 * @property int           $sampleId   [int(11)]
 * @property-read Category $category
 * @property-read Sample   $sample
 * @property int           $categoryId [int(11)]
 */
class CategorySample extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'CategorySample';
    }

    protected function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'categoryId']);
    }

    protected function getSample(): ActiveQuery
    {
        return $this->hasOne(Sample::class, ['id' => 'sampleId']);
    }

    public static function removeCategory(array $categoriesIds = []): void
    {
        if ($categoriesIds === []) {
            return;
        }

        self::deleteAll(['categoryId' => $categoriesIds]);
    }

    public static function removeSamples(array $sampleIds = []): void
    {
        if ($sampleIds === []) {
            return;
        }

        self::deleteAll(['sampleId' => $sampleIds]);
    }
}
