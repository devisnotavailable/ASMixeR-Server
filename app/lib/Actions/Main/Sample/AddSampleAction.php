<?php

declare(strict_types=1);

namespace App\Actions\Main\Sample;

use App\Actions\Admin\Sample\AddAction;
use App\Forms\Main\Sample\SampleForm;
use App\Helper\Url;
use App\Models\Sample;
use yii\web\UploadedFile;

class AddSampleAction extends AddAction
{
    public function run(): string
    {
        $model = new SampleForm(new Sample());
        $model->setScenario(SampleForm::SCENARIO_ADD);

        $this->controller->view->title = 'Add sample';

        if ($this->getRequest()->isPost()) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->load($this->getPostSampleForm()) && $model->save()) {
                $this->controller->redirect(Url::toRoute(['/']));
            }
        }

        return $this->controller->render('form', [
            'model' => $model,
        ]);
    }
}
