<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\manage\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'manufacturer_product_code') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'width') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'gross_weight_per_lbs') ?>

    <?php // echo $form->field($model, 'quantity_per_box') ?>

    <?php // echo $form->field($model, 'box_gross_weight') ?>

    <?php // echo $form->field($model, 'msrp') ?>

    <?php // echo $form->field($model, 'single_pro_discount') ?>

    <?php // echo $form->field($model, 'single_elite_discount') ?>

    <?php // echo $form->field($model, 'double_pro_discount') ?>

    <?php // echo $form->field($model, 'double_elite_discount') ?>

    <?php // echo $form->field($model, 'nmfc') ?>

    <?php // echo $form->field($model, 'package_type') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'pdf') ?>

    <?php // echo $form->field($model, 'cad') ?>

    <?php // echo $form->field($model, 'youtube') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'hazardous') ?>

    <?php // echo $form->field($model, 'commodity_type') ?>

    <?php // echo $form->field($model, 'content_type') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
