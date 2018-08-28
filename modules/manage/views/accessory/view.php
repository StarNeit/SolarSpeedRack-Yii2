<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Accessory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accessories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accessory-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('View All Accessories', ['index'], ['class' => 'btn btn-primary']) ?>
<!--        <? Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <p>Accessory name: <?= $model->slug ?></p>
    <p>Description: <?= $model->description ?></p>
    <p>Product Name: <?= $model->product ? $model->product->name : 'Not selected'?></p>

</div>
