<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Feedback;
use App\Param;
use yii\base\Exception;

/**
 * Class FeedbackService
 * @package App\Services\Api
 */
final class FeedbackService extends AbstractApiService
{
    /**
     * @return bool
     * @throws Exception
     */
    public function saveFeedback(): bool
    {
        if (!$this->request->getStr(Param::TEXT)) {
            throw new Exception('invalid param ' . Param::TEXT);
        }

        $text = $this->request->getStr(Param::TEXT);

        $feedbackModels = new Feedback();

        $feedbackModels->text = $text;

        return $feedbackModels->save();
    }
}
