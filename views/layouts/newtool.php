<?php
use yii\helpers\Html;
use app\assets\NewDesignAsset;

/* @var $this \yii\web\View */
/* @var $content string */

NewDesignAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <base href="/calculator/">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <script type="text/javascript">
        SITE_ROOT = '<?= Yii::$app->homeUrl ?>'
    </script>
    <?php if (!YII_ENV_DEV) { ?>
        <meta name="google-site-verification" content="TTJWyE_bod7ROnKXlQPCgt6d9PRZ_rYW6qDAEVQeXbg" />
        <script src="//load.sumome.com/" data-sumo-site-id="4100b0a35fdebf5b16a57411e38096eb3588f3c2344b4b9964f79b4249cb38b7" async="async"></script>
    <?php } ?>
    <title><?= Html::encode($this->title) ?> | OneClickSolar</title>
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>images/favicon.png" type="image/png">
    <?php $this->head() ?>
</head>
<body ng-app="solarApp">

<?php $this->beginBody() ?>
    <?= $content ?>
<?php if (!YII_ENV_DEV) { ?>
    <script src="//static.getclicky.com/js" type="text/javascript"></script>
    <script type="text/javascript">
        try{ clicky.init(100580074); }catch(e){};

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-39323353-1', 'auto');
        ga('send', 'pageview');
    </script>
<?php } ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>