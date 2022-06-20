<?php

declare(strict_types=1);

namespace App\Forms\User;

use App\Base\Model;
use App\Models\User;
use App\Validator\PhoneNumberValidator;

/**
 * Class ProfileForm
 * @property User $_entity
 * @package App\Forms\User
 */
class ProfileForm extends Model
{
    public const SCENARIO_WITHOUT_EDIT_PASSWORD = 'edit_without_password';
    public const SCENARIO_EDIT_PASSWORD         = 'edit_password';

    public string  $username;
    public string  $password;
    public string  $new_password;
    public string  $repeat_new_password;
    public string  $email;
    public ?string $phone = null;

    /**
     * ProfileForm constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->setAttributes($user->getAttributes(), false);
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_WITHOUT_EDIT_PASSWORD] = [
            'email',
            'phone',
        ];

        $scenarios[self::SCENARIO_EDIT_PASSWORD] = [
            'password',
            'new_password',
            'repeat_new_password',
        ];

        return $scenarios;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'email',
                    'phone',
                ],
                'filter', 'filter' => 'trim',
            ],
            ['new_password', 'validatePasswordChange'],
            ['repeat_new_password', 'string', 'skipOnEmpty' => true],
            ['password', 'string', 'skipOnEmpty' => true],
            ['new_password', 'string', 'min' => 6, 'max' => 24,],
            ['repeat_new_password', 'string', 'min' => 6, 'max' => 24,],
            ['phone', 'string', 'min' => 6, 'max' => 11,],
            [['phone'], PhoneNumberValidator::class, 'phone' => 'phone'],
        ];
    }

    /**
     * @return bool
     */
    public function validatePasswordChange(): bool
    {
        if (!$this->password || $this->password === '') {
            $this->addError('password', 'You should enter current password!');
            return false;
        }

        if (!$this->_entity->validatePassword($this->password)) {
            $this->addError('password', 'Incorrect password');
            return false;
        }

        if ($this->new_password !== $this->repeat_new_password) {
            $this->addErrors([
                'new_password'        => '',
                'repeat_new_password' => ' Error confirm',
            ]);

            return false;
        }

        return true;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = $this->_entity;

        $user->email = $this->email;
        $user->phone = $this->phone;

        if ($this->new_password && $this->getScenario() === self::SCENARIO_EDIT_PASSWORD) {
            $user->setHashPassword($this->new_password);
        }

        return $user->save();
    }
}
