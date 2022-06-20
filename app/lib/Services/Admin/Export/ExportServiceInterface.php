<?php

namespace App\Services\Admin\Export;

interface ExportServiceInterface
{
    public function getFileName(): string;

    public function getJson(): string;

    public function getPathToSave(): string;
}
