<?php
use app\assets\RenvuAsset;

RenvuAsset::register($this);

$this->title = "Upload Products cron";
?>
    <?= app\widgets\Alert::widget() ?>

    <hr />

<script> var domRenvuCron = <?= $domRenvu ?></script>
