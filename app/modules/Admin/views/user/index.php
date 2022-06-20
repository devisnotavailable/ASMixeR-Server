<?php
/**
 * @var View   $this
 * @var User[] $users
 */

use App\Helper\Html;
use App\Helper\Url;
use App\Models\User;
use App\Param;
use yii\web\View;

?>

<div class="row">
    <div class="col-xs-12 col-lg-12 col-md-12">
        <div class="box box-info">
            <div class="box-body no-padding table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Email</th>
                        <th>Last visit</th>
                        <th class="text-center"><i class="fa fa-cogs" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr data-id="<?= $user->id ?>">
                            <td><?= $user->id ?></td>
                            <td><?= $user->username ?></td>
                            <td><?= User::getTypes($user->type) ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->date_last_visit ?></td>
                            <td class="text-center">
                                <?= Html::a('Edit', Url::toRoute(['user/edit', Param::ID => $user->id]), ['class' => 'btn btn-xs btn-primary',]) ?>
                                <?php $name_button = $user->isActive() ? 'Ban' : 'Unban'; ?>
                                <?= Html::button($name_button, ['class' => 'btn btn-xs btn-danger change-status',]) ?>
                                <?= Html::a('permission', Url::toRoute(['user/permission', Param::ID => $user->id]), [
                                    'class' => 'btn btn-xs btn-primary'
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('.change-status').on('click', function () {
            let initiator = $(this);
            let id        = initiator.closest('tr').data('id');

            let answer = confirm('You want change status this users?')

            if (answer) {
                $.post('<?= Url::toRoute(['user/change-status']) ?>', {id: id}, function (response) {
                    if (response['success']) {
                        let name = initiator.text();

                        if (name === 'Ban') {
                            initiator.text('Unban');
                        } else {
                            initiator.text('Ban');
                        }
                    }
                });
            }
        });
    });
</script>