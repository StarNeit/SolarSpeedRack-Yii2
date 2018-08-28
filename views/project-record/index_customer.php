<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-record-index project-member">

    <div class="row">
<!--        <div class="col-md-3">-->
<!--            <div class="user-menu">-->
<!--                <ul>-->
<!--                    <li><a href="--><?//= \yii\helpers\Url::to(['project-record/index']) ?><!--">Projects</a></li>-->
<!--                    <li><a href="#">Menu</a></li>-->
<!--                    <li><a href="#">Menu</a></li>-->
<!--                    <li><a href="#">Menu</a></li>-->
<!--                    <li><a href="#">Menu</a></li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <?= \yii\helpers\Html::dropDownList('filter_project', 0, ['All', 'Saved', 'Assigned', 'Completed'], ['class' => 'form-control']) ?>
                </div>
            </div>
            <div class="user-content">
                <?php foreach ($model as $item) { ?>
                    <div class="project-item">
                        <div class="col-md-2">
                            <div class="title"><?= $item->name ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="descr">Project description:
                                System size: 1.86KW Date of installation: Dec 2016 Location: San Diego, California
                                Solar panels: Solar world
                                Inverters: Emphase energy
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="status"><?= \app\models\ProjectRecord::$status[$item->status] ?> </div>
                        </div>
                        <div class="col-md-2">
                            <a href="<?= \yii\helpers\Url::to(['project-record/view' , 'id' => $item->id]) ?>">
                                <button class="btn btn-warning">View detail</button>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
