<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProductPackage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-package-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sale_id',
            'required_id',
//            [
//                'attribute'=> 'sale_type',
//                'value' => $model->sale_type ? 'Amount' : 'Percent'
//            ],
//            'sale_percent',
            'sale_amount',
            'required_qty',
            'sale_start',
            'sale_end',
            [
                'attribute'=> 'status',
                'value' => \app\helpers\PHelper::statusOption($model->status)
            ]
        ],
    ]) ?>

</div>
