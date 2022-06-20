<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\Actions\Admin\Sample\AddAction;
use App\Actions\Admin\Sample\EditAction;
use App\Actions\Admin\Sample\ExportAction;
use App\Actions\Admin\Sample\ListenAction;
use App\Controllers\AdminController;
use App\Models\CategorySample;
use App\Models\Sample;
use App\Param;

/**
 * Class SampleController
 * @package Admin\Controllers
 */
final class SampleController extends AdminController
{
    public function actions(): array
    {
        return [
            'export' => ['class' => ExportAction::class,],
            'listen' => ['class' => ListenAction::class,],
            'edit'   => ['class' => EditAction::class,],
            'add'    => ['class' => AddAction::class,],
        ];
    }

    /**
     * @throws \Exception
     */
    public function actionIndex(): string
    {
        $samples = Sample::find()->all();

        $this->title = 'Samples';

        return $this->render('index', [
            'samples' => $samples,
        ]);
    }

    /**
     * @return array
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\HttpException
     */
    public function actionDelete(): array
    {
        $idSample = $this->getRequest()->postInt(Param::ID);

        if (!$idSample) {
            $this->getResponse()->set404();
        }

        $sample = Sample::findOne($idSample);
        if (!$sample) {
            $this->getResponse()->set404();
        }

        if (!$sample->delete()) {
            return ['result' => 0];
        }

        CategorySample::removeSamples([$idSample]);

        return ['result' => 1];
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

        $sample = Sample::findOne($idSample);
        if (!$sample) {
            $this->getResponse()->set404();
        }

        if ($sample->isApprove()) {
            $sample->status = Sample::STATUS_DECLINE;
        } else {
            $sample->status = Sample::STATUS_APPROVE;
        }

        return ['result' => (int)$sample->save()];
    }
}
