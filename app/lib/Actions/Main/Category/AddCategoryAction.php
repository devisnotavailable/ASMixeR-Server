<?php

declare(strict_types=1);

namespace App\Actions\Main\Category;

use App\Actions\BaseAction;
use App\Forms\Main\Category\CategoryForm;
use App\Models\Category;
use yii\web\UploadedFile;

class AddCategoryAction extends BaseAction
{
    public function run(): string
    {
        $this->controller->getView()->title = 'Add new Category';

        $category = new Category();
        $model    = new CategoryForm($category);

        if ($this->getRequest()->isPost()) {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            if ($model->load($this->getPostCategoryForm()) && $model->save()) {
                $this->controller->redirect('/');
            }
        }

        return $this->controller->render('form', [
            'model' => $model,
        ]);
    }

    private function getPostCategoryForm(): array
    {
        $postData = $this->getRequest()->post();
        unset($postData['CategoryForm']['icon']);

        return $postData;
    }
}
