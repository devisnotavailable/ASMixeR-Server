<?php

/**
 * @var View     $this
 * @var Sample[] $samples
 */

use App\Helper\Html;
use App\Helper\Url;
use App\Models\Sample;
use App\Param;
use yii\web\View;

?>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="form-group">
            <?= Html::a('Add', Url::toRoute(['sample/add']), ['class' => 'btn btn-primary',]) ?>
            <?= Html::a('Export', Url::toRoute(['sample/export']), ['class' => 'btn btn-info',]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-lg-12 col-md-12">
        <div class="box box-info">
            <div class="box-body no-padding table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Path</th>
                        <th>Dmca</th>
                        <th>Status</th>
                        <th>Date created</th>
                        <th>Date last edit</th>
                        <th class="text-center"><i class="fa fa-cogs" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($samples === []): ?>
                        <tr>
                            <td colspan="7" class="text-center">Nothing</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($samples as $sample): ?>
                            <tr data-id="<?= $sample->id ?>">
                                <td><?= $sample->id ?></td>
                                <td><?= $sample->name ?></td>
                                <td><a href="#" class="copy-path" title="Full path <?= $sample->name ?>" data-toggle="popover" data-placement="top"
                                       data-trigger="hover" data-content="<?= $sample->path ?>"><?= mb_substr($sample->path, 0, 12) . '...' ?></a></td>
                                <?php $imgSrc = $sample->dmca ? 'ok-icon.png' : 'no-icon.png'; ?>
                                <td><?= Html::img('/images/sysFiles/' . $imgSrc, [
                                        'width'  => '25px',
                                        'height' => '25px',
                                    ]) ?></td>
                                <td><?= $sample->status ?></td>
                                <td><?= $sample->dateCreated ?></td>
                                <td><?= $sample->dateLastEdit ?></td>
                                <td class="text-center">
                                    <?= Html::a('Edit', Url::toRoute(['sample/edit', Param::ID => $sample->id]), ['class' => 'btn btn-xs btn-primary',]) ?>
                                    <?= Html::a('Listen', Url::toRoute(['sample/listen', Param::ID => $sample->id]), ['class' => 'btn btn-xs btn-primary',]) ?>
                                    <?= Html::button('Delete', ['class' => 'btn btn-xs btn-danger delete',]) ?>
                                    <?php $buttonName = $sample->status !== Sample::STATUS_APPROVE ? 'Approve' : 'Decline' ?>
                                    <?= Html::button($buttonName, ['class' => 'btn btn-xs btn-info change-status',]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover();

        $('.delete').on('click', function () {
            let initiator = $(this);
            let id        = initiator.closest('tr').data('id');

            let answer = confirm('You want delete sample?');

            if (answer) {
                $.post('<?= Url::toRoute(['sample/delete']) ?>', {id: id}, function (response) {
                    if (parseInt(response['result']) === 1) {
                        initiator.closest('tr').remove();
                    }
                });
            }
        });

        $('.change-status').on('click', function () {
            let initiator = $(this);
            let id        = initiator.closest('tr').data('id');

            $.post('<?= Url::toRoute(['sample/change-status']) ?>', {id: id}, function (response) {
            });
        });

        $('.copy-path').on('click', function () {
            let initiator = $(this);
            copyToMemory(initiator.data('content'));
        });
    });
</script>
