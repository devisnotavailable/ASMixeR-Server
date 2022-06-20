<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Request;

/**
 * Class BaseApiService
 * @package App\Services\Api
 */
abstract class AbstractApiService
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
