<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,700" media="screen">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="menu_wrap">
        <div class="nav-wrap">
            <?php
            NavBar::begin([
                'brandLabel' => '<div class="logo-soc"><span><i class="fa fa-fw fa-linkedin"></i></span><span><i class="fa fa-fw fa-facebook"></i></span></div>',
                //'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-default nav-first',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    Yii::$app->user->isGuest ? ['label' => '<i class="fa fa-thumbs-up" aria-hidden="true"></i> Member', 'url' => ['/user/member-sign-up']] : '',
                    Yii::$app->user->isGuest ? ['label' => '<i class="fa fa-thumbs-up" aria-hidden="true"></i> Installer', 'url' => ['/user/installer-sign-up']] : '',
                    Yii::$app->user->isGuest ? (
                    ['label' => '<i class="fa fa-user"></i> Login', 'url' => ['/user/login']]
                    ) : (
                    ['label' => '<i class="fa fa-envelope" aria-hidden="true"></i>',  'url' => ['message/index']]
                    ),

                    !Yii::$app->user->isGuest && \app\models\Message::isUnread() ? ['label' => '<i class="fa fa-bell" aria-hidden="true"></i><span class="mess_not_read"><span class="notif"></span><span class="notif_ic">!</span></span>',  'url' => ['message/notifications']] : '',
                    !Yii::$app->user->isGuest && !\app\models\Message::isUnread() ? ['label' => '<i class="fa fa-bell" aria-hidden="true"></i><span class="mess_read"><span class="notif"></span><span class="notif_ic">!</span></span>',  'url' => ['message/notifications']] : '',

                    !Yii::$app->user->isGuest ? (
                    [
                        'label' => Yii::$app->user->identity->email,
                        'items' => [
                            ['label' => 'Projects', 'url' => ['project-record/index']],
                            '<li class="divider"></li>',
                            '<li>' . Html::a('Logout', ['/site/logout'], ['data'=>['method' => 'post',]]) . '</li>'
                        ],
                    ]
                    ) : '',

                ],
            ]);
            NavBar::end();
            ?>
        </div>
        <div class="nav-wrap1">
            <?php
            NavBar::begin([
                'brandLabel' => '<img class="logo" src="/images/site/logo.jpg">',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-default nav-sec',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    ['label' => 'Home', 'url' => ['/user/login1']],
                    ['label' => 'Products', 'url' => ['/user/login1']],
                    ['label' => 'Company', 'url' => ['/user/login1']],
                    ['label' => 'Contact', 'url' => ['/user/login1']]
                ],
            ]);
            NavBar::end();
            ?>
        </div>
    </div>