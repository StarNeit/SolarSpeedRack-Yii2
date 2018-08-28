<?php $this->beginContent('@app/views/layouts/header.php'); ?>
<?php $this->endContent(); ?>
<div class="home-container">
    <?= $content ?>
</div>
</div>
<!--wrap-->

<?php $this->beginContent('@app/views/layouts/footer.php'); ?>
<?php $this->endContent(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
