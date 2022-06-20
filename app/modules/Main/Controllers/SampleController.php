<?php

declare(strict_types=1);

namespace Main\Controllers;

use App\Actions\Main\Sample\AddSampleAction;
use App\Controllers\MainController;

final class SampleController extends MainController
{
    public function actions(): array
    {
        return [
            'add' => AddSampleAction::class,
        ];
    }
}
