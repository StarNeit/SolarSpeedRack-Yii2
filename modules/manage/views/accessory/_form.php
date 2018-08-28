<?php

use app\models\AccessoryProduct;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Accessory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accessory-form">

    <?php $form = ActiveForm::begin(['action'=>['add-product', 'id'=>$model->id]]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php
            if(!empty($model->links)) { ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Product</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($model->links as $link) { ?>
                            <tr>
                                <td>
                                    <?= $link->name ?>
                                </td>
                                <td>
                                    <?= $link->product->name ?>
                                </td>
                                <td>
                                    <?= Html::a('<i class="fa fa-trash"></i>', ['delete-link', 'id'=>$link->id], ['class'=>'btn btn-sm btn-default', 'data-confirm'=>'Are you sure?', 'data-method'=>'post']) ?>
                                </td>
                            </tr>
                            <?php
                        } ?>

                    </tbody>
                </table>
            <?php
            }
            ?>
        </div>
        <div class="col-sm-6">
            <h2>
                Add Product
            </h2>
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    $link = new AccessoryProduct();
                    echo $form->field($link, 'name')->dropDownList(['BC'=>'Black', 'MF' => 'Mill Finish']) ?>
                </div>
                <div class="col-sm-8">
                    <?= $form->field($link, 'product_id')->widget('dosamigos\selectize\SelectizeDropDownList', [
                        'model' =>$link,
                        'attribute' => 'product_id',
                        'items' => $products,
                        'clientOptions' => [
                        ],
                    ]); ?>
                </div>
                <div class="col-sm-2 text-right">
                    <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $model->isNewRecord ? $form->field($model, 'slug')->textInput(['maxlength' => true]) : '' ?>

    <?= $form->field($model, 'description')->textInput() ?>
    
    <?= $form->field($model, 'order')->textInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList([1=>'Available', 2=>'Stock Out', 3=>'Hidden']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
