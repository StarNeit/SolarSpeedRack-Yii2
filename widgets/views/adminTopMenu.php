<?php
use yii\helpers\Url;
?>
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notifications Menu -->
            <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning">0</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header">To Do</li>
                    <li>
                        <!-- Inner Menu: contains the notifications -->
                        <ul class="menu">
                            <li><!-- start notification -->
                                <a href="#">
                                    <i class="fa fa-users text-aqua"></i> to do
                                </a>
                            </li><!-- end notification -->
                        </ul>
                    </li>
                    <li class="footer"><a href="#">View all</a></li>
                </ul>
            </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="<?= Yii::$app->homeUrl ?>images/alte/avatar.png" class="user-image" alt="User Image"/>
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        <img src="<?= Yii::$app->homeUrl ?>images/alte/avatar.png" class="img-circle" alt="User Image" />
                        <p>
                            <?= Yii::$app->user->identity->username ?>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!--                    <li class="user-body">
                                          <div class="col-xs-4 text-center">
                                          </div>
                                          <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                          </div>
                                          <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                          </div>
                                        </li>-->
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?= Url::to(['/user/admin/update', 'id'=>Yii::$app->user->id]) ?>" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?= Url::to(['/site/logout']) ?>" class="btn btn-default btn-flat" data-method="post">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>