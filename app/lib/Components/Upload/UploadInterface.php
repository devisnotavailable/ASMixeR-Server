<?php

declare(strict_types=1);

namespace App\Components\Upload;

use yii\web\UploadedFile;

/**
 * Interface UploadInterface
 * @package App\Components\Upload
 */
interface UploadInterface
{
    public function upload(UploadedFile $file): string;

    public function createDirs(): void;
}
