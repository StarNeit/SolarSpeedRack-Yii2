<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Update Price #' . $model->id;

?>

        <?= Html::a('Back to Prices', ['product/price', 'id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('View Product', ['product/view', 'id' => $model->product_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update Product', ['product/update', 'id' => $model->product_id], ['class' => 'btn btn-info']) ?>

<h2>
    <?= $this->title ?>
</h2>
    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <?= $form->field($model, 'min')->textInput() ?>

    <?= $form->field($model, 'max')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'sale_price')->textInput() ?>

    <?= $form->field($model, 'pro_percent')->textInput() ?>

    <?= $form->field($model, 'elite_percent')->textInput() ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= Html::submitButton('Submit') ?>    
        </div>
    </div>

    <?php    ActiveForm::end(); ?>
