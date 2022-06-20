<?php

declare(strict_types=1);

namespace App\Components\Api;

use App\Response;
use yii\web\ErrorHandler;

/**
 * Class ApiErrorHandler
 * @package App\Components\Api
 */
class ApiErrorHandler extends ErrorHandler
{
    /**
     * @param \Error|\Exception $exception
     */
    protected function renderException($exception): void
    {
        if (\Yii::$app->has('response')) {
            $response = \Yii::$app->getResponse();
        } else {
            $response = new Response();
        }

        $response->data = $this->convertExceptionToArray($exception);
        $response->setStatusCodeByException($exception);

        $response->send();
    }

    /**
     * @param \Error|\Exception $exception
     *
     * @return array[]
     */
    protected function convertExceptionToArray($exception): array
    {
        return [
            'response' => [
                'status' => 'error',
                'errors' => [
                    ['message' => 'Bad request', 'code' => $exception->getCode(), 'text' => $exception->getMessage(),],
                ],
            ],
        ];
    }
}
