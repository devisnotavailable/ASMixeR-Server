<?php

declare(strict_types=1);

namespace App\Forms\Category;

use App\Base\Model;
use App\Models\Category;
use App\Validator\Extension\ImageExtensionValidator;
use yii\web\UploadedFile;

/**
 * Class BaseCategoryForm
 * @property Category $_entity
 * @package App\Forms\Category
 */
abstract class BaseCategoryForm extends Model
{
    public ?string       $id            = null;
    public ?string       $name          = null;
    public ?string       $nameRu        = null;
    public ?string       $iconPath      = null;
    public ?UploadedFile $icon          = null;
    public ?string       $description   = null;
    public ?string       $descriptionRu = null;
    public bool          $isAudio       = false;
    public bool          $isVideo       = false;

    public function __construct(Category $category)
    {
        parent::__construct($category);

        if ($category->isNewRecord) {
            $this->_entity->isVideo = false;
            $this->_entity->isAudio = false;
        }

        $this->setAttributes($this->_entity->getAttributes(), false);
        $this->iconPath = $category->getSrcIcon();
    }

    public function attributeLabels(): array
    {
        return [
            'name'          => 'Name',
            'nameRu'        => 'Name RU',
            'icon'          => 'Icon',
            'description'   => 'Description',
            'descriptionRu' => 'Description RU',
            'isVideo'      => 'Video Category',
            'isAudio'      => 'Audio Category',
        ];
    }

    public function rules(): array
    {
        return [
            ['name', 'required',],
            [['name', 'nameRu', 'description', 'descriptionRu',], 'string',],
            [['icon'], 'file', 'skipOnEmpty' => true,],
            ['icon', 'validateExtension',],
            [['isAudio', 'isVideo'], 'boolean',],
        ];
    }

    public function validateExtension(string $attribute): void
    {
        if (!$this->icon->extension) {
            $this->addError($attribute, 'Incorrect extension for category icon');
            return;
        }

        $validator = new ImageExtensionValidator($this->icon->extension);
        $validator->validate();

        if (!$validator->isValid()) {
            $this->addError($attribute, 'is not valid extension for sample file');
        }
    }
}
