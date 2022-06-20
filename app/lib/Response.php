<?php

declare(strict_types=1);

namespace App;

use yii\web\HttpException;

/**
 * Class Response
 * @package App
 */
class Response
{
    protected static ?Response $instance = null;

    /**
     * @return Response
     */
    public static function i(): Response
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $message
     *
     * @throws HttpException
     */
    public function set404(string $message = ''): void
    {
        throw new HttpException(404, $message);
    }

    /**
     * @param     $url
     *
     * @param int $status
     *
     * @return \yii\console\Response|\yii\web\Response
     */
    public function redirect($url, int $status = 302)
    {
        return \Yii::$app->response->redirect($url, $status);
    }

    /**
     * @param string $anchor
     *
     * @return \yii\web\Response
     */
    public function refresh(string $anchor = ''): \yii\web\Response
    {
        return \Yii::$app->response->refresh($anchor = '');
    }

    public function setJsonFormat(): void
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        if ($headers === []) {
            return;
        }

        $response_headers = \Yii::$app->response->getHeaders();

        foreach ($headers as $header => $value) {
            $response_headers->set($header, $value);
        }
    }

    /**
     * @param      $filename
     * @param null $attachmentName
     */
    public function sendFile($filename, $attachmentName = null): void
    {
        \Yii::$app->response->sendFile($filename, $attachmentName);
    }
}
