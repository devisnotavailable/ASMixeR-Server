<?php

declare(strict_types=1);

namespace App\Components\Download;

final class DownloadService implements DownloadInterface
{
    private array $headers = [];

    private ?string $path = '';
    private ?string $name = '';

    /**
     * @inheritDoc
     */
    public function setCustomHeader(array $headers): self
    {
        foreach ($headers as $key => $item) {
            $this->headers[$key] = $item;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function setFilePath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFileName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @todo refactoring
     * @inheritDoc
     */
    public function download(): void
    {
        if ($this->headers !== []) {
            foreach ($this->headers as $key => $name) {
                header(sprintf("\"%s \": %s", $key, $name));
            }
        }

        header('Content-Disposition: attachment; filename="' . $this->name . '"');

        readfile($this->path);
    }
}
