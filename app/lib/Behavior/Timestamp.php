<?php

declare(strict_types=1);

namespace App\Behavior;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Class Timestamp
 * @package App\Behavior
 */
class Timestamp extends TimestampBehavior
{
    /**@var string $createdAtAttribute */
    public $createdAtAttribute = 'date_created';

    /**@var string $updatedAtAttribute */
    public $updatedAtAttribute = 'date_updated';

    public $value;

    /**
     * @param \yii\base\Event $event
     *
     * @return int|mixed|Expression
     */
    protected function getValue($event)
    {
        return $this->value = new Expression('NOW()');
    }
}
