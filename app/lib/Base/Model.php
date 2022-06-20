<?php

namespace App\Base;

/**
 * Class Model
 * @package App\Base
 */
class Model extends \yii\base\Model
{
    public bool $isNewRecord = true;

    protected ?ActiveRecord $_entity = null;

    /**
     * @param ActiveRecord|null $activeRecord
     */
    public function __construct(ActiveRecord $activeRecord = null)
    {
        if ($activeRecord) {
            $this->_entity     = $activeRecord;
            $this->isNewRecord = $this->_entity->isNewRecord;
        }
        parent::__construct();
    }
}