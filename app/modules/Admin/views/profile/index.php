<?php
/**
 * @var View        $this
 * @var ProfileForm $model
 */

use App\Forms\User\ProfileForm;
use App\Helper\Html;
use App\Helper\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id'               => 'profile-form',
    'validateOnChange' => false,
    'validateOnBlur'   => false,
]);
?>
<div class="form-group">
    <?= Html::submitButton('Save profile', ['class' => 'btn btn-mini btn-success',]) ?>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-7 col-md-7">
        <div class="box">
            <div class="box-header primary">
            </div>
            <div class="box-body">
                <div class="form-group">
                    <div class="col-xs-6 col-lg-5 col-md-5">
                        <?= $form->field($model, 'username')->textInput(['readonly' => true,]) ?>
                    </div>
                    <div class="col-xs-6 col-lg-5 col-md-5">
                        <?= $form->field($model, 'email')->textInput() ?>
                    </div>
                    <div class="col-xs-6 col-lg-5 col-md-5">
                        <?= $form->field($model, 'phone')->textInput() ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Save profile', ['class' => 'btn btn-success submit-button', 'id' => 'profile-button',]) ?>
                <?= Html::a('Change Password', '#change-password', ['class' => 'btn btn-primary pull-right', 'data-toggle' => 'modal',]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="modal fade" id="change-password" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Current password</label>
                    <input class="form-control" type="password" name="password" title="">
                </div>
                <div class="form-group">
                    <label class="control-label">New password</label>
                    <input class="form-control" type="password" name="new_password" title="">
                </div>
                <div class="form-group">
                    <label class="control-label">Confirm password</label>
                    <input class="form-control" type="password" name="repeat_new_password" title="">
                </div>
            </div>
            <div class="modal-footer">
                <div class="submit">
                    <button class="btn btn-success" id="change-pass-btn">Ok</button>
                    <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        let pass_modal = $('#change-password');

        $('#change-pass-btn').bind('click', function (event) {
            event.preventDefault();

            $.post('<?= Url::toRoute(['change-password']) ?>', {
                password           : $('input[name="password"]').val(),
                new_password       : $('input[name="new_password"]').val(),
                repeat_new_password: $('input[name="repeat_new_password"]').val(),
            }, function (response) {
                pass_modal.find('div.form-group').removeClass('has-error').find('p.help-block').remove();
                if (Object.keys(response.errors).length > 0) {
                    for (let inp_name in response.errors) {

                        if (!response.errors.hasOwnProperty(inp_name)) {
                            continue;
                        }
                        addPasswordError(inp_name, response.errors[inp_name]);
                    }
                } else {
                    pass_modal.modal('hide');
                    window.location.reload();
                }
            }, 'json');
        });

        function addPasswordError(el, errors) {
            let input = $('input[name="' + el + '"]');
            input.closest('div.form-group').addClass('has-error').append('<p class="help-block">' + errors.join('<br/>') + '</p>');
        }
    })
</script>