<?php

/**
 * @var View       $this
 * @var Feedback[] $feedbacks
 */

use App\Models\Feedback;
use yii\web\View;

?>

<div class="row">
    <div class="col-xs-12 col-lg-12 col-md-12">
        <div class="box box-info">
            <div class="box-body no-padding table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Text</th>
                        <th>Date created</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($feedbacks === []): ?>
                        <tr>
                            <td colspan="5" class="text-center">Nothing found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($feedbacks as $feedback): ?>
                            <tr data-id="<?= $feedback->id ?>">
                                <td><?= $feedback->text ?></td>
                                <td><?= $feedback->dateCreated ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
