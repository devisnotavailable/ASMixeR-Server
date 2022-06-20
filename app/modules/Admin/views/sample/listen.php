<?php

/**
 * @var View   $this
 * @var string $src
 * @var Sample $sample
 */

use App\Helper\Html;
use App\Helper\Url;
use App\Models\Sample;
use yii\web\View;

?>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="form-group">
            <?= Html::a('<i class="fa fa-arrow-left" style="margin-right: 12px;"></i>Back', Url::toRoute(['sample/index']), [
                'class' => 'btn btn-default',]) ?>
            <?= Html::button('Delete', ['class' => 'btn  btn-danger delete',]) ?>
            <?php $buttonName = $sample->status !== Sample::STATUS_APPROVE ? 'Approve' : 'Decline' ?>
            <?= Html::button($buttonName, ['class' => 'btn btn-info change-status',]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-12 col-md-12">
        <audio controls>
            <source src="<?= $src ?>" type="audio/ogg">
            <source src="<?= $src ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
</div>

<script>
    $(function () {
        $('.delete').on('click', function () {
            let answer = confirm('You want delete sample?');

            if (answer) {
                $.post('<?= Url::toRoute(['sample/delete']) ?>', {id: <?= $sample->id ?>}, function (response) {
                    if (parseInt(response['result']) === 1) {
                        redirect('<?= Url::toRoute(['sample/index']) ?>');
                    }
                });
            }
        });

        $('.change-status').on('click', function () {
            $.post('<?= Url::toRoute(['sample/change-status']) ?>', {id: <?= $sample->id ?>}, function (response) {
                if (parseInt(response['result']) === 1) {
                    location.reload();
                }
            });
        });
    });
</script>
