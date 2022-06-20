<?php
/**
 * @var \yii\web\View   $this
 * @var UserProfileForm $model
 */

use App\Forms\Admin\User\UserProfileForm;
use App\Helper\Html;
use App\Helper\Url;
use App\Models\User;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id'                     => 'create-user-form',
    'enableClientValidation' => false,
]);
?>

    <div class="row">
        <div class="col-xs-12 col-lg-4 col-md-4">
            <div class="form-group">
                <?= Html::a('<i class="fa fa-arrow-left" style="margin-right: 12px;"></i>Back', Url::toRoute(['user/index']), [
                    'class' => 'btn btn-default',]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-lg-4 col-md-4">
            <div class="box box-success">
                <div class="box-body">
                    <?= $form->field($model, 'username')->textInput([
                        'class'        => 'form-control',
                        'autocomplete' => 'off',
                        'readonly'     => true,
                    ]) ?>
                    <?= $form->field($model, 'email')->textInput([
                        'class'        => 'form-control',
                        'autocomplete' => 'off',
                    ]) ?>
                    <?= $form->field($model, 'phone')->textInput([
                        'class'        => 'form-control',
                        'autocomplete' => 'off',
                    ]) ?>
                    <?= $form->field($model, 'type')->dropDownList(User::getTypes(), [
                        'class' => 'form-control',
                    ]) ?>
                </div>
                <div class="box-footer">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success',]) ?>
                </div>
            </div>
        </div>
    </div>

<?php ActiveForm::end() ?>