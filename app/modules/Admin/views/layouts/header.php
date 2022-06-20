<?php
/**
 * @var \yii\web\View $this
 * @var string        $content
 */

use App\App;
use App\Helper\Html;
use App\Helper\Url;

?>

<header class="main-header">
    <?= Html::a('<span class="logo-mini"></span><span class="logo-lg">Admin</span>', Url::toRoute(['/admin/site/index']), ['class' => 'logo',]) ?>
    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user fa-lg"></i>
                        <span class="hidden-xs"><?= App::i()->getCurrentUser()->username ?></span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="user-header">
                            <i class="fa fa-user fa-lg"></i>

                            <p>
                                <?= App::i()->getCurrentUser()->username ?>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('Profile', Url::toRoute(['users/profile']), [
                                    'class' => 'btn btn-default btn-flat',
                                ]) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('Logout', Url::toRoute(['auth/logout']), [
                                    'class' => 'btn btn-default btn-flat',
                                ]) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>