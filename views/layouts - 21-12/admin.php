<?php
use yii\helpers\Html;
//use yii\helpers\Url;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>favicon.ico" type="image/png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <link href="//code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript">
        SITE_ROOT = '<?= Yii::$app->homeUrl ?>'
    </script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |  
  |---------------------------------------------------------|
  
  -->
<body class="skin-green fixed">
<?php $this->beginBody() ?>
    <div class="wrapper">
      <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo"><b>NSSC Inc.</b></a>

            <!-- Header Navbar -->
            <?= app\widgets\AdminTopMenu::widget() ?>
        </header>
        <?= app\widgets\AdminSideMenu::widget() ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'tag' => 'ol',
            'encodeLabels' => false,
            'homeLink' => [ 
                    'label' => '<i class="fa fa-dashboard"></i> Home',
                    'url' => Yii::$app->homeUrl 
                ]
        ]) ?>
          <h1>
            <?= $this->title ?>
          </h1>
        </section>
            <?= \app\widgets\Alert::widget() ?>

        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          
        </div>
        <!-- Default to the left --> 
        <strong>Copyright &copy; 2015 <a href="#">NSSC Inc.</a></strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

<?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>