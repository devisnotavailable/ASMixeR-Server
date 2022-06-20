<?php

declare(strict_types=1);

namespace App\Services\Api\Sample;

use App\Services\Api\AbstractApiService;

abstract class BaseSampleService extends AbstractApiService
{
    abstract protected function validateParam(): void;
}
