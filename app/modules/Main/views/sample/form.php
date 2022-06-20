<?php

/**
 * @var View       $this
 * @var SampleForm $model
 */

use App\Assets\Packages\AjaxSelect2Assets;
use App\Forms\Main\Sample\SampleForm;
use App\Helper\Html;
use App\Helper\Url;
use App\Models\Category;
use yii\web\View;
use yii\widgets\ActiveForm;

AjaxSelect2Assets::register($this);

$form = ActiveForm::begin([
    'id'                     => 'sample-form',
    'enableClientValidation' => false,
]);

?>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="form-group">
            <?= Html::a('<i class="fa fa-arrow-left" style="margin-right: 12px;"></i>Back', Url::toRoute(['/']), [
                'class' => 'btn btn-default',]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="box box-success">
            <div class="box-body">
                <p class="warning-text">The name must contain the file extension type </p>

                <?= $form->field($model, 'name')->textInput([
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]) ?>

                <?= $form->field($model, 'categories')->dropDownList(Category::getListCategory(), [
                    'prompt'   => '',
                    'class'    => 'form-control select2',
                    'multiple' => true,
                ]) ?>

                <?= $form->field($model, 'file')->fileInput() ?>
            </div>
            <div class="box-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success',]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>
