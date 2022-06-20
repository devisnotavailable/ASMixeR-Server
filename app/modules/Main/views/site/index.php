<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 02.07.19
 * Time: 14:18
 * @var \yii\web\View $this
 */

use App\Helper\Html;
use App\Helper\Url;

?>

<div class="login-box">
    <div class="login-logo">
        <b>ASMixeR</b>
    </div>

    <div class="text-center">
        <?= Html::a('Add Category', Url::toRoute(['category/add']), ['class' => 'btn btn-flat bg-olive',]) ?>
        <?= Html::a('Add Sample', Url::toRoute(['sample/add']), ['class' => 'btn btn-flat bg-olive',]) ?>
    </div>
</div>
