<?php

use App\Components\Migration\Migration;
use App\Forms\User\RegistrationForm;
use App\Models\User;

class m191107_113901_issue_create_admin extends Migration
{
    public function safeUp()
    {
        $model = new RegistrationForm(new User());

        $model->email    = 'no-reply@example.com';
        $model->username = 'admin';
        $model->password = '123456';
        $model->phone    = '89999998887';

        if (!$model->registerAdmin()) {
            throw new \yii\db\Exception('cant create user!');
        }
    }

    public function safeDown()
    {
        User::deleteAll(['username' => 'admin']);
    }
}