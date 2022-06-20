<?php
/**
 * @var \yii\web\View $this
 * @var Permission[]  $manager_permissions
 */

use App\Helper\Html;
use App\Helper\Url;
use App\RBAC\RbacHelper;
use yii\rbac\Permission;

?>
<?= Html::beginForm() ?>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="form-group">
            <?= Html::a('<i class="fa fa-arrow-left" style="margin-right: 12px;"></i>Back', Url::toRoute(['user/index']), [
                'class' => 'btn btn-default',]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <?php foreach (RbacHelper::getRules() as $block_name => $rules): ?>
                <div class="col-md-2">
                    <div class="box box-success collapsed-box">
                        <div class="box-header with-border">
                            <?= RbacHelper::getRuleBlockName($block_name) ?>
                            <div class="pull-right">
                                <?= Html::button('<i class="fa fa-check"></i>', ['class' => 'btn btn-success btn-xs select-all']) ?>
                                <?= Html::button('<i class="fa fa-times"></i>', ['class' => 'btn btn-default btn-xs unselect-all']) ?>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php foreach ($rules as $rule => $message) : ?>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <?= Html::checkBox('permissions[' . $rule . ']', $manager_permissions[$rule] ? true : null) ?>
                                            <?= $message ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-xs-12">
        <?= Html::submitButton('Apply', ['class' => 'btn btn-success',]) ?>
    </div>
</div>

<?= Html::endForm() ?>

<script>
    $('.select-all').click(function () {
        let block  = $(this).closest('.box');
        let inputs = block.find('input:checkbox');
        inputs.each(function () {
            $(this).prop('checked', true);
        });
    });

    $('.unselect-all').click(function () {
        let block  = $(this).closest('.box');
        let inputs = block.find('input:checkbox');
        inputs.each(function () {
            $(this).prop('checked', false);
        });
    });
</script>