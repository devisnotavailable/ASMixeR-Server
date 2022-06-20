<?php

declare(strict_types=1);

namespace App\Forms\Admin\User;

use App\Base\Model;
use App\Models\User;
use App\Validator\PhoneNumberValidator;

/**
 * Class UserProfileForm
 * @property User $_entity
 * @package App\Forms\Admin
 */
class UserProfileForm extends Model
{
    public string  $email;
    public int     $type;
    public ?string $phone = null;
    public string  $username;

    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->setAttributes($this->_entity->getAttributes(), false);
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'type'  => 'type',
            'phone' => 'phone',
            'email' => 'email',
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['email', 'phone'], 'string',
            ],
            ['email', 'validateUnique'],
            ['email', 'email'],
            [['type'], 'in', 'range' => array_keys(User::getTypes()),],
            [['phone'], PhoneNumberValidator::class, 'phone' => 'phone'],
        ];
    }

    /**
     * @param $attribute
     */
    public function validateUnique($attribute): void
    {
        $user = User::findOne([$attribute => $this->$attribute]);

        if ($user && ($user->username != $this->username)) {
            $this->addError($attribute,$attribute . ' user exist');
        }
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_entity;

        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->type  = $this->type;

        return $user->save();
    }
}
