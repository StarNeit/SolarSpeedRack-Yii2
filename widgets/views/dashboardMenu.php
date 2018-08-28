<?php
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-sm-12">
        <div class="control-panel__row control__panel-mob">

            <?php foreach ($items as $item) {
            /*    if(isset($item['items'])) { ?>
                    <a href="<?= Url::to($item['url']); ?>" class="control-panel__cube control-panel__images <?= $item['active'] ? 'active' : '' ?>">
                        <div class="control-panel__cube-img-holder">
                            <img src="img/<?= $item['img'] ?>" alt="<?= $item['label'] ?>">
                        </div>
                        <p class="control-panel__cube-text"><?= $item['label'] ?></p>
                    </a>
          <?php } else { */?>
                    <a href="<?= Url::to($item['url']); ?>" class="control-panel__cube control-panel__images <?= $item['active'] ? 'active' : '' ?>">
                        <div class="control-panel__cube-img-holder">
                            <img src="/img/<?= $item['img'] ?>" alt="<?= $item['label'] ?>">
                        </div>
                        <p class="control-panel__cube-text"><?= $item['label'] ?></p>
                    </a>
                <?php// } ?>
            <?php } ?>
        </div>
    </div>
</div>
