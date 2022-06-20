<?php

declare(strict_types=1);

namespace App\Forms\Sample;

use App\Base\Model;
use App\Models\CategorySample;
use App\Models\Sample;
use yii\web\UploadedFile;

/**
 * @property Sample $_entity
 */
abstract class BaseSampleForm extends Model
{
    public ?string       $name       = '';
    public ?string       $uuid       = '';
    public ?bool         $dmca       = false;
    public ?array        $categories = [];
    public ?UploadedFile $file       = null;
    public ?string       $status     = Sample::STATUS_NO_APPROVE;

    public const SCENARIO_ADD  = 'add';
    public const SCENARIO_EDIT = 'edit';

    public function __construct(Sample $sample)
    {
        parent::__construct($sample);
        $this->setAttributes($this->_entity->getAttributes(), false);

        if ($sample->categories) {
            /**@var CategorySample $categorySample */
            foreach ($sample->categories as $categorySample) {
                $this->categories[$categorySample->categoryId] = $categorySample->categoryId;
            }
        }
    }

    public function rules(): array
    {
        return [
            [[ 'categories',], 'required',],
            [['name',], 'string',],
            [['dmca',], 'boolean'],
            [['file'], 'file', 'skipOnEmpty' => false, 'on' => self::SCENARIO_ADD],
            ['status', 'in', 'range' => array_keys(Sample::getCategoriesList(),)],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Name',
            'uuid' => 'Uuid',
            'file' => 'Sample file',
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_ADD] = [
            'file',
            'name',
            'dmca',
            'status',
            'categories',
        ];

        $scenarios[self::SCENARIO_EDIT] = [
            'name',
            'dmca',
            'status',
            'categories',
            'file',
        ];

        return $scenarios;
    }
}
