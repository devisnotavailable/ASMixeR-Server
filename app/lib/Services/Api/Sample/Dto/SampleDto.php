<?php

declare(strict_types=1);

namespace App\Services\Api\Sample\Dto;

use App\Models\Sample;
use DateTimeImmutable;

final class SampleDto
{
    private int                $id;
    private string             $name;
    private string             $path;
    private bool               $dmca;
    private DateTimeImmutable  $dateCreated;
    private ?DateTimeImmutable $dateLastEdit = null;
    private string             $status;
    private string             $uuid;
    private string             $link;

    public static function createFromArray(array $model): SampleDto
    {
        $dto = new self();

        $dto->id          = (int)$model['id'];
        $dto->name        = (string)$model['name'];
        $dto->path        = (string)$model['path'];
        $dto->dmca        = (bool)$model['dmca'];
        $dto->uuid        = (string)$model['uuid'];
        $dto->dateCreated = new DateTimeImmutable($model['dateCreated']);
        if ($model['dateLastEdit']) {
            $dto->dateLastEdit = new DateTimeImmutable($model['dateLastEdit']);
        }
        $dto->status = (string)$model['status'];

        $dto->link = Sample::getLinkFile($dto->uuid);

        return $dto;
    }

    public function printArray(): array
    {
        return [
            'id'           => $this->getId(),
            'name'         => $this->getName(),
            'status'       => $this->getStatus(),
            'dateCreated'  => $this->getDateCreated()->getTimestamp(),
            'dateLastEdit' => $this->getDateLastEdit() ? $this->getDateLastEdit()->getTimestamp() : 0,
            'uuid'         => $this->getUuid(),
             //'path'         => $this->getPath(),
            'link'         => $this->getLink(),
            'dmca'         => $this->isDmca(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isDmca(): bool
    {
        return $this->dmca;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateCreated(): DateTimeImmutable
    {
        return $this->dateCreated;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDateLastEdit(): ?DateTimeImmutable
    {
        return $this->dateLastEdit;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
