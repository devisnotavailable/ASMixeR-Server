<?php

/**
 * @var View       $this
 * @var SampleForm $model
 */

use App\Forms\Admin\Sample\SampleForm;
use App\Helper\Html;
use App\Helper\Url;
use App\Models\Category;
use App\Models\Sample;
use yii\web\View;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id'                     => 'sample-form',
    'enableClientValidation' => false,
]);

?>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="form-group">
            <?= Html::a('<i class="fa fa-arrow-left" style="margin-right: 12px;"></i>Back', Url::toRoute(['sample/index']), [
                'class' => 'btn btn-default',]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="box box-success">
            <div class="box-body">
                <?= $form->field($model, 'uuid')->textInput([
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                    'readonly'     => true,
                ]) ?>

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

                <?= $form->field($model, 'dmca')->checkBox([
                    'label' => 'DMCA',
                    'No'    => '0',
                    'Yes'   => '1',
                ]) ?>

                <?= $form->field($model, 'status')->dropDownList(Sample::getCategoriesList(), [
                    'class'    => 'form-control select2',
                    'multiple' => false,
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
