<?php

declare(strict_types=1);

namespace App\Actions\Admin\Sample;

use App\Actions\BaseAction;
use App\Forms\Admin\Sample\SampleForm;
use App\Helper\Url;
use App\Models\Sample;
use yii\web\UploadedFile;

class AddAction extends BaseAction
{
    public function run(): string
    {
        $model = new SampleForm(new Sample());
        $model->setScenario(SampleForm::SCENARIO_ADD);

        $this->controller->view->title = 'Add sample';

        if ($this->getRequest()->isPost()) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->load($this->getPostSampleForm()) && $model->save()) {
                $this->controller->redirect(Url::toRoute(['sample/index']));
            }
        }

        return $this->controller->render('form', [
            'model' => $model,
        ]);
    }

    protected function getPostSampleForm(): array
    {
        $postData = $this->getRequest()->post();
        unset($postData['SampleForm']['file']);

        if (is_string($postData['SampleForm']['categories'])) {
            $postData['SampleForm']['categories'] = [];
        }

        return $postData;
    }
}
