<?php

declare(strict_types=1);

namespace App\Actions\Console\Tool;

use App\Actions\BaseAction;
use App\App;
use App\Helper\File;
use yii\helpers\Console;

class ClearFileAction extends BaseAction
{
    private const TIME = 12;

    public function run(): void
    {
        $path = App::i()->getRootPath() . '/web/load/sample/';

        $files = scandir($path);
        $count = 0;

        foreach ($files as $file) {
            if (in_array($file, ['.', '..', '.gitignore'], true)) {
                continue;
            }

            $fullPath  = $path . $file;
            $timestamp = File::getFileTime($fullPath);

            if ((time() - $timestamp) > self::TIME) {
                $count += File::delete($fullPath) ? 1 : 0;
            }
        }

        Console::stdout('Deleted ' . $count . ' files' . PHP_EOL);
    }
}
