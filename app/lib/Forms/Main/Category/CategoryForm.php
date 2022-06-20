<?php

declare(strict_types=1);

namespace App\Forms\Main\Category;

use App\App;
use App\Components\Upload\UploadPublic;
use App\Forms\Category\BaseCategoryForm;
use App\Models\Category;

/**
 * Class CategoryForm
 * @property Category $_entity
 * @package App\Forms\Admin\Category
 */
class CategoryForm extends BaseCategoryForm
{
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $category = $this->_entity;

        $category->name          = $this->name;
        $category->nameRu        = $this->nameRu;
        $category->descriptionRu = $this->descriptionRu;
        $category->description   = $this->description;
        $category->isVideo       = $this->isVideo;
        $category->isAudio       = $this->isAudio;
        $category->status = Category::STATUS_NO_APPROVE;

        if (!$category->isNewRecord) {
            $category->dateLastEdit = new \DateTimeImmutable();
        }

        $category->save();

        if (!$category->save()) {
            return false;
        }

        if ($this->icon) {
            $uploadManager = new UploadPublic();
            $path          = App::i()->getPathWeb() . '/images/categories/' . $category->id . '/';
            $uploadManager->setFolderDestination($path);
            $uploadManager->createDirs();
            $savePath           = $uploadManager->upload($this->icon);
            $category->iconPath = $savePath;

            return $category->save();
        }

        return true;
    }
}
