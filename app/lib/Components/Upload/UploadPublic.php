<?php

declare(strict_types=1);

namespace App\Components\Upload;

use App\Components\Upload\Exceptions\FileException;
use App\Helper\Directory;
use yii\web\UploadedFile;

final class UploadPublic extends AbstractUpload
{
    /**
     * @throws FileException
     */
    public function upload(UploadedFile $file): string
    {
        $this->checkUploadFile($file);
        $this->file = $file;

        $name       = $file->baseName;
        $pathToSave = $this->getFolderDestination() . '/' . $name . '.' . $file->extension;

        if (!$this->file->saveAs($pathToSave)) {
            throw new FileException('cant save file to server');
        }

        return $pathToSave;
    }

    public function createDirs(): void
    {
        Directory::creatingNestedDirectories($this->folderDestination);
    }
}
