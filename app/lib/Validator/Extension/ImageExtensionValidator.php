<?php

declare(strict_types=1);

namespace App\Validator\Extension;

class ImageExtensionValidator extends BaseExtensionValidator
{
    public function validate(): void
    {
        $this->isValid = in_array($this->extension, self::getListExtensions(), true);
    }

    public static function getListExtensions(): array
    {
        return [
            'jpg',
            'png',
            'jpeg',
        ];
    }
}
