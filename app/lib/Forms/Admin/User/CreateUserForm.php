<?php

declare(strict_types=1);

namespace App\Forms\Admin\User;

use App\Base\Model;
use App\Models\User;
use App\Validator\PhoneNumberValidator;

/**
 * Class CreateUserForm
 * @property User $_entity
 * @package App\Forms\Admin
 */
class CreateUserForm extends Model
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $email    = null;
    public ?string $type     = null;
    public ?string $phone    = null;

    /**
     * CreateUserForm constructor.
     *
     * @param User|null $user
     */
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
            'username' => 'username',
            'password' => 'password',
            'type'     => 'type',
            'phone'    => 'phone',
            'email'    => 'email',
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'username', 'password', 'type', 'email', 'phone',
                ], 'required',
            ],
            [['username', 'email', 'phone',], 'filter', 'filter' => 'trim',],
            [['username', 'email','phone',], 'unique', 'targetClass' => User::class, 'message' => 'This {attribute} is already used!',],
            ['username', 'string', 'min' => 3, 'max' => 30,],
            ['email', 'email',],
            ['email', 'string', 'max' => 55,],
            ['password', 'string', 'min' => 6,],
            ['type', 'in', 'range' => array_keys(User::getTypes()),],
            ['phone', 'string',],
            ['phone', 'string', 'min' => 6, 'max' => 11,],
            [['phone'], PhoneNumberValidator::class, 'phone' => 'phone',],
        ];
    }

    /**
     * @param $attribute
     */
    public function validateUnique($attribute): void
    {
        if (User::findOne([$attribute => $this->$attribute])) {
            $this->addError($attribute,$attribute . ' user exist');
        }
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

        $user = $this->_entity;

        $user->username = $this->username;
        $user->email    = $this->email;
        $user->type     = $this->type;
        $user->phone    = $this->phone;
        $user->status   = User::STATUS_ACTIVE;
        $user->setHashPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();

        return $user->save();
    }
}
