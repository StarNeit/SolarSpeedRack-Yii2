<?php
use yii\helpers\Html;
use yii\widgets\Menu;
Use yii\bootstrap\Dropdown;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

?>
        <nav class="navigation">
            <div class="container">
                <div class="navigation__layout">
                    <div class="navigation__left-holder">
                        <div class="dropdown">
                            <button type="button" class="dropbtn">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </button>

                            <?php
                            echo Menu::widget([
                                'options' => ['class' => 'dropdown-hide navigation__list'],
                                'encodeLabels' => true,
                                'submenuTemplate' => "\n<ul class='dropdown-hide navigation__list'>\n{items}\n</ul>\n",
                                'linkTemplate' => '<a class="navigation__list-link" href="{url}">{label}</a>',
                                'items' => [
                                    ['label' => 'HOME', 'url' => ['/user/login1'], 'options' => ['class' => 'navigation__list-item']],
                                    ['label' => 'PRODUCTS', 'url' => ['#'], 'options' => ['class' => 'navigation__list-item']],
                                    ['label' => 'COMPANY', 'url' => ['#'], 'options' => ['class' => 'navigation__list-item']],
                                    ['label' => 'CONTACT US', 'url' => ['#'], 'options' => ['class' => 'navigation__list-item']],
                                    // ['label' => 'My Dashboard', 'url' => ['/manage'], 'options' => ['class' => 'navigation__list-item']]
                                ],
                            ]);
                            ?>
                        </div>

                        <span class="navigation__title">
                            <a href="<?php echo Yii::$app->homeUrl ?>"> 
                                <!--<img class="logo" src="/images/site/logo.jpg"> </a>-->
                                One Click Solar
                            </a>
                        </span>
                    </div>

                    <div class="navigation__right-holder">
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle"> 
                                <?= !Yii::$app->user->isGuest ? Yii::$app->user->identity->email : "Login" ?> <b class="caret"></b>
                            </a>

                            <?php
                            echo Dropdown::widget([
                                'encodeLabels' => false,
                                'items' => [
                                    Yii::$app->user->isGuest ? ['label' => '<i class="fa fa-hand-o-right" aria-hidden="true"></i> Member', 'url' => ['/user/member-sign-up']] : '',
                                    Yii::$app->user->isGuest ? ['label' => '<i class="fa fa-hand-o-right" aria-hidden="true"></i> Installer', 'url' => ['/user/installer-sign-up']] : '',
                                    Yii::$app->user->isGuest ? (
                                            ['label' => '<i class="fa fa-user"></i> Login', 'url' => ['/user/login']]
                                            ) : (
                                            ['label' => '<i class="fa fa-envelope" aria-hidden="true"></i> Message', 'url' => ['message/index']]
                                            ),
                                    !Yii::$app->user->isGuest ? ['label' => '<i class="fa fa-hand-o-right" aria-hidden="true"></i> Projects', 'url' => ['project-record/index']] : '',
                                    !Yii::$app->user->isGuest ? [
                                        'label' => '<i class="fa fa-hand-o-right" aria-hidden="true"></i> Logout',
                                        'url' => ['site/logout'],
                                        'linkOptions' => ['data-method' => 'post'],
                                        ]
                                    : '',
                                ],
                            ]);
                            ?>
                        </div>

                        <?php
                        if (!Yii::$app->user->isGuest && \app\models\Message::isUnread()) {
                            ?>
                            <a hef=" <?php echo Url::to(['message/index']) ?>" />
                            <i class="fa fa-envelope navigation__icons" aria-hidden="true"></i><span class = "mess_not_read"><span class = "notif"></span><span class = "notif_ic">!</span></span> 
                            </a> 
                        <?php }
                        ?>
                        <?php
                        if (!Yii::$app->user->isGuest && !\app\models\Message::isUnread()) {
                            ?> 
                            <a hef=" <?php echo Url::to(['message/notifications']) ?>" />
                            <i class="fa fa-bell navigation__icons" aria-hidden="true"></i><span class = "mess_read"><span class = "notif"></span><span class = "notif_ic">!</span></span> 
                            </a>
                        <?php }
                        ?>
                    </div>
                </div>
            </div>
        </nav>