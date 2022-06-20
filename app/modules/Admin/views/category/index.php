<?php
/**
 * @var View       $this
 * @var Category[] $categories
 */

use App\Helper\Html;
use App\Helper\Url;
use App\Models\Category;
use App\Param;
use yii\web\View;

?>

<div class="row">
    <div class="col-xs-12 col-lg-4 col-md-4">
        <div class="form-group">
            <?= Html::a('Add', Url::toRoute(['category/add']), ['class' => 'btn btn-primary',]) ?>
            <?= Html::a('Export', Url::toRoute(['category/export']), ['class' => 'btn btn-info',]) ?>
            <?= Html::a('Export CategorySample', Url::toRoute(['category/export-category-sample']), ['class' => 'btn btn-info',]) ?>
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
                        <th>Name RU</th>
                        <th>Status</th>
                        <th>Date created</th>
                        <th>Date last edit</th>
                        <th class="text-center"><i class="fa fa-cogs" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($categories === []): ?>
                        <tr>
                            <td colspan="5" class="text-center">Nothing found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $category): ?>
                            <tr data-id="<?= $category->id ?>">
                                <td><?= $category->id ?></td>
                                <td><?= $category->name ?></td>
                                <td><?= $category->nameRu ?></td>
                                <td><?= $category->status ?></td>
                                <td><?= $category->dateCreated ?></td>
                                <td><?= $category->dateLastEdit ?></td>
                                <td class="text-center">
                                    <?= Html::a('Edit', Url::toRoute(['category/edit', Param::ID => $category->id]), ['class' => 'btn btn-xs btn-primary',]) ?>
                                    <?= Html::button('Delete', ['class' => 'btn btn-xs btn-danger delete',]) ?>
                                    <?php $buttonName = $category->status !== Category::STATUS_APPROVE ? 'Approve' : 'Decline' ?>
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
        $('.delete').on('click', function () {
            let initiator = $(this);
            let id        = initiator.closest('tr').data('id');

            let answer = confirm('You want delete sample?');

            if (answer) {
                $.post('<?= Url::toRoute(['category/delete']) ?>', {id: id}, function (response) {
                    if (parseInt(response['result']) === 1) {
                        initiator.closest('tr').remove();
                    }

                    if (response['message'] !== '') {
                        alert(response['message']);
                    }
                });
            }
        });

        $('.change-status').on('click', function () {
            let initiator = $(this);
            let id        = initiator.closest('tr').data('id');

            $.post('<?= Url::toRoute(['category/change-status']) ?>', {id: id}, function (response) {
            });
        });
    });
</script>
