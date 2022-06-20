<?php

declare(strict_types=1);

namespace App\Helper;

/**
 * Class Tool
 * @package App\Helper
 */
class Tool
{

    /**
     * @param bool $value
     *
     * @return string
     */
    public static function boolToText(bool $value): string
    {
        $map = [
            true  => 'ok',
            false => 'error',
        ];

        return $map[$value];
    }

    public static function WebFolderToSrc(string $path): string
    {
        if ($path === '') {
            return '';
        }

        return explode('web', $path)[1] ?? '';
    }
}
