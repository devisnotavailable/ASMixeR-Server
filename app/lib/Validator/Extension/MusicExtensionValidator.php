<?php

declare(strict_types=1);

namespace App\Validator\Extension;

/**
 * Class MusicExtensionValidator
 * @package App\Validator
 */
final class MusicExtensionValidator extends BaseExtensionValidator
{
    public function validate(): void
    {
        $this->isValid = in_array($this->extension, self::getListExtensions(), true);
    }

    public static function getListExtensions(): array
    {
        return [
            'mp3',
            'ogg',
            'ac3',
        ];
    }
}
