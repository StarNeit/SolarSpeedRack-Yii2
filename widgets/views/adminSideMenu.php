<?php
use yii\helpers\Url;
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->homeUrl ?>images/alte/avatar.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header"></li>
            <?php foreach ($items as $item) {
                if(isset($item['items'])) { ?>
                    <li class="treeview <?= $item['active'] ? 'active' : '' ?>" >
                        <a href="#">
                        <span>
                            <!--<i class="fa <?php // $item['icon'] ?>"></i>-->
                            <?= $item['label'] ?>
                        </span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($item['items'] as $ci) { ?>
                                <li class="<?= $ci['active'] ? 'active' : '' ?>" >
                                    <a href="<?= \yii\helpers\Url::to($ci['url']); ?>">
                                <span>
                                    <?= $ci['label'] ?>
                                </span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li <?= $item['active'] ? 'class="active"' : '' ?> >
                        <a href="<?= \yii\helpers\Url::to($item['url']); ?>">
                        <span>
                            <!--<i class="fa <?php // $item['icon'] ?>"></i>-->
                            <?= $item['label'] ?>
                        </span>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>