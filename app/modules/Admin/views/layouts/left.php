<?php
/**
 * @var \yii\web\View $this
 */

use App\App;
use App\Widgets\Menu;

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?= Menu::widget(App::i()->getCurrentModule()->params['module_menu']) ?>
    </section>
</aside>