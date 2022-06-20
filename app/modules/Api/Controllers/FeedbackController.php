<?php

declare(strict_types=1);

namespace Api\Controllers;

use App\Controllers\ApiControllers;
use App\Helper\Tool;
use App\Services\Api\FeedbackService;

/**
 * Class FeedbackController
 * @package Api\Controllers
 */
final class FeedbackController extends ApiControllers
{
    /**
     * @return \string[][]
     */
    protected function verbs(): array
    {
        return [
            'index' => ['POST',],
        ];
    }

    /**
     * @return string[]
     * @throws \yii\base\Exception
     * @api {POST} /feedback
     *
     */
    public function actionIndex(): array
    {
        $service = new FeedbackService($this->getRequest());
        $result  = $service->saveFeedback();

        return ['status' => Tool::boolToText($result)];
    }
}
