<?php

declare(strict_types=1);

namespace App\Actions\Admin\Sample;

use App\Actions\BaseAction;
use App\Forms\Admin\Sample\SampleForm;
use App\Helper\Url;
use App\Models\Sample;
use App\Param;
use yii\web\UploadedFile;

class EditAction extends BaseAction
{
    public function run(): string
    {
        $id = $this->getRequest()->getInt(Param::ID);
        if (!$id) {
            $this->getResponse()->set404();
        }

        $sample = Sample::findOne($id);
        if (!$sample) {
            $this->getResponse()->set404();
        }

        $model = new SampleForm($sample);
        $model->setScenario(SampleForm::SCENARIO_EDIT);

        $this->controller->view->title = 'Edit sample [' . $sample->name . ']';

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

    private function getPostSampleForm(): array
    {
        $postData = $this->getRequest()->post();
        unset($postData['SampleForm']['file']);

        if (is_string($postData['SampleForm']['categories'])) {
            $postData['SampleForm']['categories'] = [];
        }

        return $postData;
    }
}
