<?php

namespace App\Models;

use App\App;
use App\Base\ActiveRecord;
use App\Helper\File;
use yii\db\ActiveQuery;

/**
 * Class Sample
 * @package App\Models
 * @property int           $id           [int(11)]
 * @property string        $name         [varchar(512)]
 * @property string        $path         [varchar(255)]
 * @property bool          $dmca         [tinyint(1)]
 * @property int           $dateCreated  [timestamp]
 * @property int           $dateLastEdit [timestamp]
 * @property string        $status       [varchar(50)]
 * @property-read Sample[] $categories
 * @property string        $uuid         [varchar(255)]
 */
class Sample extends ActiveRecord
{
    public const STATUS_APPROVE    = 'approve';
    public const STATUS_NO_APPROVE = 'no approve';
    public const STATUS_DECLINE    = 'decline';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'Sample';
    }

    public function isApprove(): bool
    {
        return $this->status === self::STATUS_APPROVE;
    }

    protected function getCategories(): ActiveQuery
    {
        return $this->hasMany(CategorySample::class, ['sampleId' => 'id']);
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        File::delete($this->path);
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public static function getLinkFile(string $uuid): string
    {
        return App::i()->getApiDomain() . '/sample/get-file?uuid=' . $uuid;
    }

    /**
     * @param string|null $category
     *
     * @return string|string[]
     */
    public static function getCategoriesList(?string $category = null): array|string
    {
        $list = [
            self::STATUS_NO_APPROVE => self::STATUS_NO_APPROVE,
            self::STATUS_APPROVE    => self::STATUS_APPROVE,
            self::STATUS_DECLINE    => self::STATUS_DECLINE,
        ];

        return $list[$category] ?? $list;
    }
}
