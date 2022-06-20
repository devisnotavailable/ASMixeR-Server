<?php

declare(strict_types=1);

namespace App\Controllers;

use ethercreative\ratelimiter\RateLimiter;

/**
 * Class ApiControllers
 * @package App\Controllers
 */
class ApiControllers extends BaseController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['rateLimiter'] = [
            'class'                  => RateLimiter::class,
            'rateLimit'              =>100,
            'timePeriod'             => 600,
            'separateRates'          => false,
            'enableRateLimitHeaders' => false,
        ];
        return $behaviors;
    }
}
