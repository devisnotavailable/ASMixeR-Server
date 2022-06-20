<?php

declare(strict_types=1);

namespace App\Components\Upload;

use App\Base\ActiveRecord;
use App\Components\Upload\Exceptions\FileException;
use App\Helper\Directory;
use App\Models\Sample;
use yii\web\UploadedFile;

/**
 * Class UploadSample
 * @package App\Components\Upload
 */
final class UploadSample extends AbstractUpload
{
    private const COUNTER_FILE_ON_FOLDER = 1000;
    private ?Sample $sample = null;
    private ?string $name   = null;

    /**
     * @throws FileException
     */
    public function upload(UploadedFile $file): string
    {
        $this->checkUploadFile($file);
        $this->file = $file;

        $name = $this->getFileName();
        $pathToSave = $this->getFolderDestination() . $name;

        if (!$this->file->saveAs($pathToSave)) {
            throw new FileException('cant save file to server');
        }

        return $pathToSave;
    }

    public function getFileName(): string
    {
        if ($this->name === null) {
            $this->createName();
        }

        return $this->name;
    }

    private function createName(): void
    {
        $this->name = $this->file->getBaseName() . '_' . time()
            . '_' . $this->sample->id . '.' . $this->file->getExtension();
    }

    public function getPathSaved(): string
    {
        return $this->getFolderDestination() . $this->getFileName();
    }

    public function generateHash(string $string): string
    {
        $hash = hash('sha512', $string);
        if (!$hash) {
            return md5($string);
        }

        return $hash;
    }

    /**
     * @throws FileException
     */
    public function createDirs(): void
    {
        $this->creatingDisBasedOnCounter();
        Directory::creatingNestedDirectories($this->folderDestination);
    }

    /**
     * @throws FileException
     */
    private function creatingDisBasedOnCounter(): void
    {
        if (!$this->folderDestination) {
            throw new FileException('no set path for folderDestination');
        }

        if (!is_dir($this->folderDestination)) {
            throw new FileException('is no dir');
        }

        $id = (int)$this->getModel()->id;

        $folderName = intdiv($id, self::COUNTER_FILE_ON_FOLDER) * self::COUNTER_FILE_ON_FOLDER;

        if ($folderName === 0) {
            $folderName = self::COUNTER_FILE_ON_FOLDER;
        }

        $this->folderDestination .= '/' . $folderName . '/';
    }

    /**
     * @return Sample
     */
    public function getModel(): ActiveRecord
    {
        return $this->sample;
    }

    public function setModel(ActiveRecord $record): UploadInterface
    {
        $this->sample = $record;
        return $this;
    }
}
