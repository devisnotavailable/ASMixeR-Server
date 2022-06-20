<?php

declare(strict_types=1);

namespace Api\Controllers;

use App\Controllers\ApiControllers;

/**
 * Class HelpController
 * @package Api\Controllers
 */
final class HelpController extends ApiControllers
{
    /**
     * @return array
     */
    public function actionIndex(): array
    {
        return [
            'response' => [
                'description' => 'This is asmixer api',
            ],
        ];
    }
}
