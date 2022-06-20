<?php

declare(strict_types=1);

namespace App\Services\Api\Category\Dto;

use App\Models\Category;
use DateTimeImmutable;

final class CategoryDto
{
    private int                $id;
    private string             $name;
    private string             $nameRu;
    private string             $description;
    private string             $descriptionRu;
    private DateTimeImmutable  $dateCreated;
    private ?DateTimeImmutable $dateLastEdit = null;
    private string             $srcIcon;
    private bool               $isAudio;
    private bool               $isVideo;

    /**
     * @param array $model
     *
     * @return CategoryDto
     * @throws \Exception
     */
    public static function createFromArray(array $model): CategoryDto
    {
        $dto = new self();

        $dto->id = (int)$model['id'];

        $dto->name          = (string)$model['name'];
        $dto->nameRu        = (string)$model['nameRu'];
        $dto->description   = (string)$model['description'];
        $dto->descriptionRu = (string)$model['descriptionRu'];
        $dto->dateCreated   = new DateTimeImmutable($model['dateCreated']);

        if ($model['iconPath']) {
            $dto->srcIcon = Category::getLinkIcon($model['iconPath']);
        } else {
            $dto->srcIcon = "";
        }

        if ($model['dateLastEdit']) {
            $dto->dateLastEdit = new DateTimeImmutable($model['dateLastEdit']);
        }

        $dto->isAudio = (bool)$model['isAudio'];
        $dto->isVideo = (bool)$model['isVideo'];

        return $dto;
    }

    /**
     * @return array
     */
    public function printArray(): array
    {
        return [
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'nameRu'        => $this->getNameRu(),
            'description'   => $this->getDescription(),
            'descriptionRu' => $this->getDescriptionRu(),
            'src'           => $this->getSrcIcon(),
            'dateCreated'   => $this->getDateCreated()->getTimestamp(),
            'dateLastEdit'  => $this->getDateLastEdit() ? $this->getDateLastEdit()->getTimestamp() : 0,
            'isVideo'       => $this->isVideo(),
            'isAudio'       => $this->isAudio(),
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
    public function getNameRu(): string
    {
        return $this->nameRu;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDescriptionRu(): string
    {
        return $this->descriptionRu;
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
    public function getSrcIcon(): string
    {
        return $this->srcIcon;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->isVideo;
    }

    /**
     * @return bool
     */
    public function isAudio(): bool
    {
        return $this->isAudio;
    }
}
