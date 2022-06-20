<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\Actions\Admin\Category\ExportAction;
use App\Actions\Admin\Category\ExportCategoryAction;
use App\Controllers\AdminController;
use App\Forms\Admin\Category\CategoryForm;
use App\Helper\Url;
use App\Models\Category;
use App\Models\CategorySample;
use App\Param;
use yii\web\UploadedFile;

/**
 * Class CategoryController
 * @package Admin\Controllers
 */
final class CategoryController extends AdminController
{
    public function actions(): array
    {
        return [
            'export'                 => ['class' => ExportAction::class,],
            'export-category-sample' => ['class' => ExportCategoryAction::class,],
        ];
    }

    public function actionIndex(): string
    {
        $this->title = 'Categories';

        $categories = Category::find()->all();

        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionEdit(): string
    {
        $id = $this->getRequest()->getInt(Param::ID);

        if (!$id) {
            $this->getResponse()->set404();
        }

        $category = Category::findOne($id);

        if (!$category) {
            $this->getResponse()->set404();
        }

        $this->title = 'Edit category ' . $category->name;

        $model = new CategoryForm($category);

        if ($this->getRequest()->isPost()) {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            if ($model->load($this->getPostCategoryForm()) && $model->save()) {
                $this->redirect(Url::toRoute(['category/index']));
            }
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionAdd(): string
    {
        $this->title = 'Add new Category';

        $category = new Category();
        $model    = new CategoryForm($category);

        if ($this->getRequest()->isPost()) {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            if ($model->load($this->getPostCategoryForm()) && $model->save()) {
                $this->redirect(Url::toRoute(['category/index']));
            }
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    private function getPostCategoryForm(): array
    {
        $postData = $this->getRequest()->post();
        unset($postData['CategoryForm']['icon']);

        return $postData;
    }

    /**
     * @return int[]
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\HttpException
     */
    public function actionDelete(): array
    {
        $idCategory = $this->getRequest()->postInt(Param::ID);

        if (!$idCategory) {
            $this->getResponse()->set404();
        }

        $category = Category::findOne($idCategory);
        if (!$category) {
            $this->getResponse()->set404();
        }

        if (!$category->delete()) {
            return [
                'result'  => 0,
                'message' => '',
            ];
        }

        CategorySample::removeCategory([$idCategory]);

        return [
            'result'  => 1,
            'message' => '',
        ];
    }

    /**
     * @return array
     * @throws \yii\web\HttpException
     */
    public function actionChangeStatus(): array
    {
        $idSample = $this->getRequest()->postInt(Param::ID);

        if (!$idSample) {
            $this->getResponse()->set404();
        }

        $category = Category::findOne($idSample);
        if (!$category) {
            $this->getResponse()->set404();
        }

        if ($category->isApprove()) {
            $category->status = Category::STATUS_DECLINE;
        } else {
            $category->status = Category::STATUS_APPROVE;
        }

        return ['result' => (int)$category->save()];
    }
}
