<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

/**
 * Class DbException
 * @package App\Exceptions\Api
 */
class DbException extends ApiException
{
    public function __construct($code, string $message, array $data = [], \Throwable $previous = null)
    {
        parent::__construct($code, $message, $data, $previous);
    }
}
