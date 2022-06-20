<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Yii;
use yii\web\HttpException;

/**
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends HttpException
{
    public const CODE_INVALID_PARAM = 400001;
    public const CODE_IS_NOT_APPROVE = 400002;

    public const CODE_NOT_FOUND = 404001;

    public const CODE_DATABASE_ERROR  = 500001;
    public const CODE_NOT_UPLOAD_FILE = 500002;

    public function __construct(int $code, string $message, array $data = [], \Throwable $previous = null)
    {
        $this->data = $data;
        $status     = (int)substr((string)$code, 0, 3);
        if ($previous && !$previous instanceof \Exception) {
            $previous = new \Exception($previous->__toString());
        }
        parent::__construct($status, $message, $code, $previous);
    }
}
