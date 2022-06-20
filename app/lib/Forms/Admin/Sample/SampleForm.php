<?php

declare(strict_types=1);

namespace App\Forms\Admin\Sample;

use App\App;
use App\Components\Upload\Exceptions\FileException;
use App\Components\Upload\UploadSample;
use App\Forms\Sample\BaseSampleForm;
use App\Helper\File;
use App\Models\CategorySample;
use Rhumsaa\Uuid\Uuid;

class SampleForm extends BaseSampleForm
{
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $sample = $this->_entity;

        $sample->dmca         = $this->dmca;
        $sample->dateLastEdit = $sample->isNewRecord ? null : new \DateTimeImmutable();
        $sample->name         = $this->name;
        $sample->status       = $this->status;

        if (!$sample->save()) {
            return false;
        }

        if ($this->getScenario() === self::SCENARIO_ADD) {
            $sample->uuid = Uuid::uuid4()->toString() .'-'.$sample->id;
        }

        if ($this->file) {
            if ($this->getScenario() === self::SCENARIO_EDIT) {
                File::delete($sample->path);
            }

            $sample->name = $this->file->getBaseName() . '.' . $this->file->getExtension();

            $upload = new UploadSample();
            try {
                $upload->setModel($sample);
                $upload->setFolderDestination(App::i()->getPathStaticFiles() . '/samples');
                $upload->createDirs();
                $upload->upload($this->file);
            } catch (FileException $exception) {
                CategorySample::deleteAll(['sampleId' => $sample->id]);
                $sample->delete();
                return false;
            }

            $sample->path = $upload->getPathSaved();

            if (!$sample->save()) {
                return false;
            }
        }

        $transaction = App::i()->getDb()->beginTransaction();

        if (!$transaction) {
            return false;
        }

        CategorySample::removeSamples([$sample->id]);
        $batch = [];

        foreach ($this->categories as $id) {
            $batch[] = [(int)$id, $sample->id];
        }

        $command = App::i()->getDb()->createCommand()->batchInsert(CategorySample::tableName(), ['categoryId', 'sampleId'], $batch);

        if ($command->execute() === 0) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
        return true;
    }
}
