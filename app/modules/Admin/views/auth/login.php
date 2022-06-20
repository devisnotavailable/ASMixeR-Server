<?php
/**
 * @var \yii\web\View             $this
 * @var \App\Forms\User\LoginForm $model
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$fieldOptions1 = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$fieldError = [
    'options'       => ['class' => 'form-group has-feedback'],
    'inputTemplate' => ""
];

$form = ActiveForm::begin([
    'id'               => 'login-form',
    'validateOnChange' => false,
    'validateOnBlur'   => false,
]);
?>

<div class="login-box">
    <div class="login-logo">Login</div>
    <div class="login-box-body">

        <?= $form->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <?= $form->field($model, 'error', $fieldError)->label(false)->hiddenInput() ?>

        <div class="row text-center">
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', [
                    'class' => 'btn btn-primary btn-block btn-flat right',
                    'name'  => 'login-button',
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>