<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update Prices', ['price', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php 
    echo '<table class="table table-bordered"><thead><th>Qty From</th><th>Qty To</th><th>Price</th><th>Sale Price</th><th>&nbsp;</th></thead><tbody>';
    foreach ($model->prices as $price) {
        if($price->max == 0) {
            echo '<tr><td>' . $price->min . '+</td><td>&nbsp;</td><td>' . $price->price . '</td><td>' . $price->sale_price . '</td><td>' . 
                    Html::a('Update', ['product/update-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-info']) . ' ' .
                    Html::a('Delete', ['product/del-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-danger']) . '</td></tr>';
        } else {
            echo '<tr><td>' . $price->min . '</td><td>' . $price->max . '</td><td>' . $price->price . '</td><td>' . $price->sale_price . '</td><td>' . 
                    Html::a('Update', ['product/update-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-info']) . ' ' .
                    Html::a('Delete', ['product/del-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-danger']) . '</td></tr>';
        }
    }
    echo '</tbody></table><hr />';
    echo Html::a('Update Prices', ['product/price', 'id'=>$model->id], ['class'=>'btn btn-info']);
    echo '<hr />';
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'company_id',
                'value'=> $model->company->name
            ],
            'name',
            'features:html',
            [
                'attribute' => 'on_sale',
                'value'=> $model->on_sale ? 'Yes' : 'No'
            ],
            'manufacturer_product_code',
            'meta.rated_power',
            'meta.length',
            'meta.width',
            'meta.height',
            'meta.weight',
            'meta.quantity_per_box',
            'meta.box_weight',
            'nmfc',
            'package_type',
            [
                'attribute' => 'category_id',
                'value'=> $model->category->name
            ],
            'pdf',
            'cad',
            'youtube',
            'rating',
            'class',
            'commodity_type',
            'content_type',
            'created_by',
            [
                'attribute' => 'status',
                'value' => \app\helpers\PHelper::statusOption($model->status)
            ],
        ],
    ]) ?>

</div>
