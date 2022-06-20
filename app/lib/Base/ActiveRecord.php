<?php

namespace App\Base;

/**
 * Class ActiveRecord
 * @package App\Base
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        foreach ($this->getAttributes() as $key => $value) {
            if ($value instanceof \DateTimeImmutable) {
                $this->setAttribute($key, $value->format('Y-m-d H:i:s'));
            }
        }

        return parent::beforeSave($insert);
    }
}