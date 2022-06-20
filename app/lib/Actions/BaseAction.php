<?php

declare(strict_types=1);

namespace App\Actions;

use App\App;
use App\Request;
use App\Response;
use yii\base\Action;

/**
 * Class BaseAction
 * @package App\Actions
 */
class BaseAction extends Action
{
    /**
     * @param $key
     * @param $message
     */
    public function setFlash($key, $message): void
    {
        App::i()->getApp()->session->setFlash($key, $message);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return Request::i();
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return Response::i();
    }
}
