<?php

declare(strict_types=1);

namespace App\Forms\User;

use App\Base\Model;
use App\Models\User;
use App\Validator\PhoneNumberValidator;

/**
 * Class RegistrationForm
 * @package App\Forms\User
 */
class RegistrationForm extends Model
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $email    = null;
    public ?string $phone    = null;

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'username' => 'username',
            'password' => 'password',
            'email'    => 'email',
            'phone'    => 'phone',
        ];
    }

    /**
     * @param string $attribute
     * @param bool   $with_required
     *
     * @return string
     */
    public function getAttributeLabel($attribute, bool $with_required = false): string
    {
        return parent::getAttributeLabel($attribute) . ($with_required ? ($this->isAttributeRequired($attribute) ? ' *' : '') : '');
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'username',
                    'password',
                    'email',
                    'phone'
                ], 'required',
            ],
            [['username', 'email', 'phone',], 'filter', 'filter' => 'trim'],
            [['username', 'email','phone',], 'unique', 'targetClass' => User::class, 'message' => 'This {attribute} is already used!'],
            ['username', 'string', 'min' => 3, 'max' => 30,],
            ['email', 'email',],
            ['email', 'string', 'max' => 55,],
            ['password', 'string', 'min' => 6,],
            ['phone', 'string', 'min' => 6, 'max' => 11,],
            [['phone'], PhoneNumberValidator::class, 'phone' => 'phone',],
        ];
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function registration(): bool
    {
        return $this->createUser(User::TYPE_DEFAULT_USER);
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function registerAdmin(): bool
    {
        return $this->createUser(User::TYPE_ADMIN);
    }

    /**
     * @param int $type
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    private function createUser(int $type): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();

        $user->username = $this->username;
        $user->setHashPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->email  = $this->email;
        $user->phone  = $this->phone;
        $user->type   = $type;
        $user->status = User::STATUS_ACTIVE;

        return $user->save(false);
    }
}
