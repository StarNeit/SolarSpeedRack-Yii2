<?php $this->beginContent('@app/views/layouts/header.php'); ?>
<?php $this->endContent(); ?>
<div id="fullpage" class="fullpage-wrapper">
    <?= $content ?>
    
    
<?php $this->beginContent('@app/views/layouts/footer.php'); ?>
</div>
 
<!--wrap-->

<?php $this->endContent(); ?>

<?php $this->endBody() ?>


<script>
    $(".dropdown-toggle").dropdown();
    if (screen && screen.width > 768) {
        document.write('<script type="text/javascript" src="js/jquery.fullPage.min.js"><\/script>');
        document.write('<script src="js/jquery.stellar.min.js"><\/script>');
    }
</script>
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
                function () {
                    (b[l].q = b[l].q || []).push(arguments)
                });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = 'https://www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>
<?php $this->endPage() ?>
