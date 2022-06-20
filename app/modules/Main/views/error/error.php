<?php
/**
 * @var yii\web\View $this
 * @var string       $name
 * @var string       $message
 * @var Exception    $exception
 *
 */

$this->title = $name;
?>
<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>
        <div class="error-content">
            <h3><?= $name ?></h3>
        </div>
    </div>
</section>