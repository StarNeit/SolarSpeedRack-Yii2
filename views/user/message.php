<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this   yii\web\View
 * @var $title  string
 * @var $module dektrium\user\Module
 */

$this->title = $title;

?>
<?php if(Yii::$app->user->isGuest) { ?>
    <a href="/user/login" class="pull-right btn btn-default" data-method="post">Log In</a>
<?php
} else { ?>
    <a class="pull-right btn btn-default" href="/<?= Yii::$app->user->identity->dashboard() ?>" data-method="post">My Dashboard</a>
<?php
} ?>

<?php
if (!empty($modal))
    { $this->registerJs('$(\'#noticeModal\').modal()') ?>
        <!-- Modal -->
        <div class="modal fade" id="noticeModal" tabindex="-1" role="dialog" aria-labelledby="noticeModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="noticeModalLabel"><i class="fa fa-hand-o-up" aria-hidden="true"></i> <?= $modal['title'] ?></h4>
              </div>
              <div class="modal-body">
                  <i class="fa fa-info-circle" aria-hidden="true"></i> <?= $modal['body'] ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
<?php } ?>
