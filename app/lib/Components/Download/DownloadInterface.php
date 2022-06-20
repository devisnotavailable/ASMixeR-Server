<?php

declare(strict_types=1);

namespace App\Components\Download;

interface DownloadInterface
{
    /**
     * @param array $headers
     *
     * @return DownloadInterface
     */
    public function setCustomHeader(array $headers): self;

    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @param string $path
     *
     * @return DownloadInterface
     */
    public function setFilePath(string $path): self;

    /**
     * @param string $name
     *
     * @return DownloadInterface
     */
    public function setFileName(string $name): self;

    /**
     * @return void
     */
    public function download(): void;
}
