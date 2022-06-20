<?php
/**
 * @var View         $this
 * @var CategoryForm $model
 */

use App\Forms\Main\Category\CategoryForm;
use App\Helper\Html;
use App\Helper\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id'                     => 'category-form',
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
                <?= $form->field($model, 'name')->textInput([
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]) ?>
                <?= $form->field($model, 'nameRu')->textInput([
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]) ?>

                <?= $form->field($model, 'description')->textInput([
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]) ?>

                <?= $form->field($model, 'descriptionRu')->textInput([
                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                ]) ?>

                <?= $form->field($model, 'isAudio')->checkbox([]) ?>

                <?= $form->field($model, 'isVideo')->checkbox([]) ?>

                <?php if ($model->iconPath): ?>
                <div style="width: 100%;height: 100%;">
                    <?= Html::img($model->iconPath, [
                        'width'  => '100%',
                        'height' => '100%',
                    ]) ?>
                </div>
                <?php endif; ?>

                <?php //$form->field($model, 'icon')->fileInput() ?>

            </div>
            <div class="box-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success',]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>
