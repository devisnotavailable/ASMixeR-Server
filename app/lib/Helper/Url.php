<?php

declare(strict_types=1);

namespace App\Helper;

/**
 * Class Url
 * @package App\Helper
 */
class Url extends \yii\helpers\Url
{
    /**
     * @param string $url
     *
     * @return bool
     */
    public static function isValid(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
