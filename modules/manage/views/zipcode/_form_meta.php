<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ZipCode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zip-code-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <?= $form->field($model, 'building_code')->dropDownList([1=>'ASCE 7-05', 2=>'ASCE 7-10']) ?>

    <?= $form->field($model, 'wind')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'snow')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'seismic_ss')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'pk')->textInput(['maxlength' => 20]) ?>

    <div class="form-group row">
        <div class="col-sm-4 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
