<?php

declare(strict_types=1);

namespace Console\Controllers;

use App\Actions\Console\Tool\ClearFileAction;
use App\Controllers\ConsoleController;

final class ToolController extends ConsoleController
{
    public function actions(): array
    {
        return [
            'clearSample' => ['class' => ClearFileAction::class,],
        ];
    }
}
