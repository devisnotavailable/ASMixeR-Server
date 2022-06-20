<?php

declare(strict_types=1);

namespace App\Services\Api\Sample;

use App\App;
use App\Components\Upload\Exceptions\FileException;
use App\Components\Upload\UploadInterface;
use App\Components\Upload\UploadSample;
use App\Exceptions\Api\ApiException;
use App\Exceptions\Api\DbException;
use App\Exceptions\Api\InvalidateParam;
use App\Models\Category;
use App\Models\CategorySample;
use App\Models\Sample;
use App\Param;
use App\Validator\Extension\MusicExtensionValidator;
use Rhumsaa\Uuid\Uuid;
use yii\web\UploadedFile;

final class AddSampleService extends BaseSampleService
{
    private string       $categoryIds;
    private UploadedFile $file;
    private bool         $dmca = true;

    /**
     * @param UploadInterface $upload
     *
     * @return bool
     * @throws DbException
     * @throws InvalidateParam
     * @throws \yii\db\Exception
     * @throws ApiException
     */
    public function add(UploadInterface $upload): bool
    {
        $this->validateParam();

        $dbTransaction = App::i()->getDb()->beginTransaction();

        if (!$dbTransaction) {
            throw new DbException(ApiException::CODE_DATABASE_ERROR, 'error database');
        }

        $sample = new Sample();

        $sample->name = $this->file->getBaseName() . '.' . $this->file->getExtension();
        $sample->dmca = $this->dmca;
        $sample->uuid = Uuid::uuid4()->toString();

        if (!$sample->save()) {
            throw new DbException(ApiException::CODE_DATABASE_ERROR, 'not saved sample to database');
        }

        try {
            $this->saveCategories($sample->id);
        } catch (\Exception $exception) {
            $dbTransaction->rollBack();
        }

        $dbTransaction->commit();

        try {
            $this->uploadFile($sample, $upload);
        } catch (FileException $exception) {
            $dbTransaction->rollBack();
            CategorySample::deleteAll(['sampleId' => $sample->id]);
            $sample->delete();
            throw new ApiException(ApiException::CODE_NOT_UPLOAD_FILE, 'not uploaded file');
        }

        $sample->path = $upload->getPathSaved();
        $sample->save();

        return true;
    }

    /**
     * @return void
     * @throws InvalidateParam
     */
    protected function validateParam(): void
    {
        $this->treatmentUploadedFile();

        $categoryIds = $this->request->getStr(Param::CATEGORY_IDS);

        if (!$categoryIds) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'Invalid categories');
        }

        $this->categoryIds = $categoryIds;

        $this->dmca = (bool)$this->request->getInt(Param::DMCA, 0);
    }

    /**
     * @param int $sampleId
     *
     * @throws DbException
     * @throws \yii\db\Exception
     */
    private function saveCategories(int $sampleId): void
    {
        $cats = explode(',', $this->categoryIds);

        $realIds = Category::find()
            ->select('id')
            ->where(['id' => $cats])
            ->column();

        $batch = [];
        foreach ($realIds as $catId) {
            $batch[] = [$sampleId, $catId];
        }

        $res = App::i()->getDb()->createCommand()->batchInsert(CategorySample::tableName(), ['sampleId', 'categoryId',], $batch)->execute();

        if ($res === 0) {
            throw new DbException(ApiException::CODE_DATABASE_ERROR, 'not saved categories to database');
        }
    }

    /**
     * @throws FileException
     */
    private function uploadFile(Sample $sample, UploadInterface $upload): void
    {
        /**@var UploadSample $upload */
        $upload->setModel($sample);
        $upload->setFolderDestination(App::i()->getPathStaticFiles() . '/samples');
        $upload->createDirs();
        $upload->upload($this->file);
    }

    /**
     * @return void
     * @throws InvalidateParam
     */
    private function treatmentUploadedFile(): void
    {
        $uploaded_file = UploadedFile::getInstanceByName(Param::SAMPLE_FILE);

        if (!$uploaded_file) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'Invalid file');
        }

        $validator = new MusicExtensionValidator($uploaded_file->extension);
        $validator->validate();

        if (!$validator->isValid()) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'not allowed extension file');
        }

        if ($uploaded_file->size > 12582912) {
            throw new InvalidateParam(ApiException::CODE_INVALID_PARAM, 'more than the maximum file size');
        }

        $this->file = $uploaded_file;
    }
}
