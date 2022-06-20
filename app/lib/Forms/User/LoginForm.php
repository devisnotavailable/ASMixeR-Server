<?php

declare(strict_types=1);

namespace App\Forms\User;

use App\App;
use App\Base\Model;
use App\Models\User;
use DateTime;
use Exception;
use Yii;

/**
 * class LoginForm
 * @property User $user
 * @property User $_entity
 * @package App\Forms\User
 */
class LoginForm extends Model
{
    public ?string $username    = null;
    public ?string $password    = null;
    public bool    $remember_me = true;

    public ?string $error = null;

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'username'    => 'username',
            'password'    => 'password',
            'remember_me' => 'Remember Me',
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
                    'username',
                    'password',
                ],
                'required',
            ],
            [
                'remember_me',
                'boolean',
            ],
            [
                'password', 'validatePassword',
            ],
        ];
    }

    /**
     * @param $attribute
     */
    public function validatePassword($attribute): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError($attribute, 'No access');
            } elseif ($user->status === User::STATUS_BANNED) {
                $this->addError($attribute, 'You are banned from this resource');
            } else if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password');
            }
        }
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        switch (App::i()->getCurrentModule()->id) {
            case App::MODULE_ADMIN:
                $type = User::TYPE_ADMIN;
                break;
            default:
                $type = User::TYPE_DEFAULT_USER;
                break;
        }

        if ($this->_entity === null) {
            $this->_entity = User::findOne(['username' => $this->username, 'type' => $type]);
        }

        return $this->_entity;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_entity;

        $user->date_last_visit = (new \DateTimeImmutable());

        if ($user->save()) {
            return Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);
        }

        return false;
    }
}
