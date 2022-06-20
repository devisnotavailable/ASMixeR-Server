<?php

declare(strict_types=1);

namespace App\Helper;

/**
 * Class File
 * @package App\Helper
 */
class File
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public static function exist(string $path): bool
    {
        return file_exists($path) && is_readable($path) && is_file($path);
    }

    public static function delete(string $path): bool
    {
        if (!self::exist($path)) {
            return false;
        }

        return unlink($path);
    }

    /**
     * @param string $from
     * @param string $to
     * @param bool   $deleteOriginal
     *
     * @return bool
     * @throws \Exception
     */
    protected static function moving(string $from, string $to, bool $deleteOriginal = false): bool
    {
        if ($from === '' || $to === '') {
            throw new \Exception('not set path');
        }

        if (!self::exist($from)) {
            throw new \Exception('Not found file');
        }

        if (!copy($from, $to)) {
            return false;
        }

        if ($deleteOriginal) {
            return unlink($from);
        }

        return true;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return bool
     * @throws \Exception
     */
    public static function copy(string $from, string $to): bool
    {
        return self::moving($from, $to);
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return bool
     * @throws \Exception
     */
    public static function move(string $from, string $to): bool
    {
        return self::moving($from, $to, true);
    }

    /**
     * @param string $path
     *
     * @return false|int
     */
    public static function getFileTime(string $path)
    {
        $path = preg_replace('/\?v=[\d]+$/', '', $path);
        return filemtime($path);
    }
}
