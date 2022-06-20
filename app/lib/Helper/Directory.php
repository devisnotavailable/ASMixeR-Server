<?php

declare(strict_types=1);

namespace App\Helper;

/**
 * Class Directory
 * @package App\Helper
 */
final class Directory
{
    /**
     * @param string $path
     */
    public static function creatingNestedDirectories(string $path): void
    {
        $tags  = explode('/', $path);
        $mkDir = "";

        foreach ($tags as $folder) {
            $mkDir .= $folder . "/";
            self::createDir($mkDir);
        }
    }

    /**
     * @param string $path
     */
    public static function createDir(string $path): void
    {
        if (!is_dir($path) && !mkdir($path) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    /**
     * @param string $path
     */
    public static function deleteDir(string $path): void
    {
        $dir = opendir($path);
        while (false !== ($file = readdir($dir))) {
            if (($file !== '.') && ($file !== '..')) {
                if (is_dir($path . '/' . $file)) {
                    self::deleteDir($path . '/' . $file);
                } else {
                    unlink($path . '/' . $file);
                }
            }
        }
        closedir($dir);
        rmdir($path);
    }

    /**
     * @param string $path_to_folder
     *
     * @return string
     */
    public static function getSize(string $path_to_folder): string
    {
        $line = exec('du -sh ' . $path_to_folder);
        return trim(str_replace($path_to_folder, '', $line));
    }
}
