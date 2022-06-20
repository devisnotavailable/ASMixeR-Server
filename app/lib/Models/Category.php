<?php

namespace App\Models;

use App\App;
use App\Base\ActiveRecord;
use App\Helper\File;
use App\Helper\Tool;
use yii\db\ActiveQuery;

/**
 * Class Category
 * @package App\Models
 * @property int         $id            [int(11)]
 * @property string      $name          [varchar(512)]
 * @property int         $dateCreated   [timestamp]
 * @property int         $dateLastEdit  [timestamp]
 * @property string      $nameRu        [varchar(512)]
 * @property string      $iconPath      [varchar(512)]
 * @property string      $description   [varchar(255)]
 * @property-read string $srcIcon
 * @property string      $descriptionRu [varchar(255)]
 * @property bool        $isVideo       [tinyint(1)]
 * @property bool        $isAudio       [tinyint(1)]
 * @property string      $status        [varchar(50)]
 *
 * @property-read CategorySample[] $samplesCategory
 */
class Category extends ActiveRecord
{
    public const STATUS_APPROVE ='approve';
    public const STATUS_DECLINE = 'decline';
    public const STATUS_NO_APPROVE ='no approve';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'Category';
    }

    public function getSrcIcon(): string
    {
        if ($this->iconPath === '') {
            return '';
        }

        return explode('web', $this->iconPath)[1] ?? '';
    }

    protected function getSamplesCategory(): ActiveQuery
    {
        return $this->hasMany(CategorySample::class, ['categoryId' => 'id']);
    }

    public function afterDelete(): void
    {
        parent::afterDelete();

        if ($this->iconPath) {
            File::delete($this->iconPath);
        }
    }

    public static function getLinkIcon(string $path): string
    {
        $src = Tool::WebFolderToSrc($path);
        return App::i()->getApiDomain() . (str_replace('//', '/', $src));
    }

    public static function getListCategory(): array
    {
        $cats = self::find()
            ->select(['id', 'name'])
            ->where(['status' => self::STATUS_APPROVE])
            ->asArray()
            ->all();

        if ($cats === []) {
            return [];
        }

        $result = [];
        foreach ($cats as $item) {
            $result[(int)$item['id']] = $item['name'];
        }

        return $result;
    }

    public function isApprove(): bool
    {
        return $this->status === self::STATUS_APPROVE;
    }
}
