<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\User;
use App\Request;
use App\Response;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class BaseController
 * @property string                          $flash
 * @property \yii\web\IdentityInterface|null $currentUser
 * @property \App\Response                   $response
 * @property \App\Request                    $request
 * @property string                          $title
 * @package App\Controllers
 */
class BaseController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * @return array
     */
    protected function verbs(): array
    {
        return [];
    }

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if ($this->getRequest()->isAjax()) {
            $this->getResponse()->setJsonFormat();
        }

        return parent::beforeAction($action);
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

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->view->title = $title;
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->view->title;
    }

    /**
     * @param $key
     * @param $message
     */
    public function setFlash($key, $message): void
    {
        App::i()->getApp()->session->setFlash($key, $message);
    }

    /**
     * @return \yii\web\IdentityInterface|User
     */
    public function getCurrentUser()
    {
        return App::i()->getCurrentUser();
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return App::i()->logout();
    }

    /**
     * @param $data
     *
     * @return array
     */
    protected function getAjaxSelectResult($data): array
    {
        return ['results' => $data];
    }
}
