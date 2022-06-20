<?php

declare(strict_types=1);

namespace App\Validator;

use App\Base\Model;
use yii\base\InvalidConfigException;
use yii\validators\Validator;

/**
 * Class PhoneNumberValidator
 * @package App\Validator
 */
class PhoneNumberValidator extends Validator
{
    public ?string $phone = null;

    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        if (!$this->phone) {
            throw new InvalidConfigException('The "number" property must be set.');
        }
    }

    /**
     * @param Model  $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute): void
    {
        $phone = $model->{$this->phone};

        if (!preg_match("/\\+?([0-9]{2})-?([0-9]{3})-?([0-9]{6,7})/", $phone)) {
            $this->addError($model, $attribute, 'Incorrect phone number');
            return;
        }

        $model->{$this->phone} = str_replace('+', '', $phone);
    }
}
