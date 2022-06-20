<?php

declare(strict_types=1);

namespace App\Validator\Extension;

use App\Validator\AbstractValidator;

abstract class BaseExtensionValidator extends AbstractValidator
{
    protected string $extension;

    public function __construct(string $extension)
    {
        $this->extension = $extension;
    }

    abstract public static function getListExtensions(): array;
}
