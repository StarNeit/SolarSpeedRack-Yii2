<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Installer Dashboard');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading text-center navigation__title">  
        <?= Html::encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-10  col-sm-offset-1 text-sans-serif FontSmall">
                <?= Yii::$app->controller->renderPartial('_view/_inspection', ['inspection_dataProvider' => $inspection_dataProvider,]); ?>
            </div>
            <div class="col-sm-10  col-sm-offset-1">
                <?= Yii::$app->controller->renderPartial('_view/_installation', [ 'installation_dataProvider' => $installation_dataProvider]); ?>
            </div>
        </div>
    </div>
</div>