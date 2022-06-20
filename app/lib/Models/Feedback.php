<?php

namespace App\Models;

use App\Base\ActiveRecord;

/**
 * Class Feedback
 * @package App\Models
 * @property int    $id          [int(11)]
 * @property string $text
 * @property int    $dateCreated [timestamp]
 */
class Feedback extends ActiveRecord
{
    /**
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'Feedback';
    }
}