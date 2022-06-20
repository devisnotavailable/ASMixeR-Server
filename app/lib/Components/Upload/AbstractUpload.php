<?php

declare(strict_types=1);

namespace App\Components\Upload;

use App\Components\Upload\Exceptions\FileException;
use yii\web\UploadedFile;

abstract class AbstractUpload implements UploadInterface
{
    protected string        $folderDestination = '';
    protected ?UploadedFile $file              = null;

    public function setFolderDestination(string $path): void
    {
        $this->folderDestination = $path;
    }

    public function getFolderDestination(): string
    {
        return $this->folderDestination;
    }

    /**
     * @param UploadedFile $file
     *
     * @return void
     * @throws FileException
     */
    protected function checkUploadFile(UploadedFile $file): void
    {
        if ($file->getHasError()) {
            throw new FileException('cant upload file');
        }

        if (!$this->folderDestination) {
            throw new FileException('No set folderDestination');
        }
    }
}
