<?php
/**
 * @var View   $this
 * @var string $content
 */

use App\Widgets\Alert;
use yii\web\View;

?>
<div class="content-wrapper">
    <section class="content">
        <?= Alert::widget() ?>
        <h3><?= $this->title ?></h3>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>ASMixer</b>
    </div>
    <div class="clearfix"></div>
</footer>
