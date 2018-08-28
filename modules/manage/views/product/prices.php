<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Edit Prices for - product #' . $model->id;

?>

        <?= Html::a('View Product', ['product/view', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update Product', ['product/update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <p><?= $model->product_link ? Html::a('link', $model->product_link, ['target'=>'_blank']) : '' ?></p>

<?php
echo '<table class="table table-bordered"><thead><th>Qty From</th><th>Qty To</th><th>Price</th><th>Sale Price</th><th>PRO %</th><th>Elite %</th><th>&nbsp;</th></thead><tbody>';
foreach ($model->prices as $price) {
    if($price->max == 0) {
        echo '<tr><td>' . $price->min . '+</td><td>&nbsp;</td><td>' . $price->price . '</td><td>' . $price->sale_price . '</td><td>' . $price->pro_percent . '</td><td>' . $price->elite_percent . '</td><td>' . 
                Html::a('Update', ['product/update-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-info']) . ' ' .
                Html::a('Delete', ['product/del-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-danger']) . '</td></tr>';
    } else {
        echo '<tr><td>' . $price->min . '</td><td>' . $price->max . '</td><td>' . $price->price . '</td><td>' . $price->sale_price . '</td><td>' . $price->pro_percent . '</td><td>' . $price->elite_percent . '</td><td>' . 
                Html::a('Update', ['product/update-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-info']) . ' ' .
                Html::a('Delete', ['product/del-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-danger']) . '</td></tr>';
    }
}
        
echo '</tbody></table><hr />';

?>
<h2>
    Add New Price
</h2>
    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <?= $form->field($newprice, 'min')->textInput() ?>

    <?= $form->field($newprice, 'max')->textInput() ?>

    <?= $form->field($newprice, 'price')->textInput() ?>

    <?= $form->field($newprice, 'sale_price')->textInput() ?>

    <?= $form->field($newprice, 'pro_percent')->textInput() ?>

    <?= $form->field($newprice, 'elite_percent')->textInput() ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= Html::submitButton('Submit') ?>    
        </div>
    </div>

    <?php    ActiveForm::end(); ?>
