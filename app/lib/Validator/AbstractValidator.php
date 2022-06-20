<?php

declare(strict_types=1);

namespace App\Validator;

/**
 * Class AbstractValidator
 * @package App\Validator
 */
abstract class AbstractValidator
{
    protected bool $isValid = false;

    abstract public function validate(): void;

    public function isValid(): bool
    {
        return $this->isValid;
    }
}
