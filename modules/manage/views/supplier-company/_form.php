<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierCompany */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'status')->dropDownList(\app\helpers\PHelper::statusOption()) ?>

    <h2>Default Address</h2>
    
    <?= $form->field($address, 'first_name')->textInput(['placeholder'=>'First Name']) ?>
    
    <?= $form->field($address, 'last_name')->textInput(['placeholder'=>'Last Name']) ?>
    
    <?= $form->field($address, 'address1')->textInput(['placeholder'=>'Street Address']) ?>
    
    <?= $form->field($address, 'address2')->textInput(['placeholder'=>'Street Address Line 2']) ?>
    
    <?= $form->field($address, 'office_number')->textInput(['placeholder'=>'Area Code - Phone Number']) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
