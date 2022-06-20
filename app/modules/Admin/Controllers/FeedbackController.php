<?php

declare(strict_types=1);

namespace Admin\Controllers;

use App\Controllers\AdminController;
use App\Models\Feedback;

final class FeedbackController extends AdminController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $feedbacks = Feedback::find()
            ->orderBy('dateCreated DESC')
            ->all();

        return $this->render('index', [
            'feedbacks' => $feedbacks,
        ]);
    }
}
