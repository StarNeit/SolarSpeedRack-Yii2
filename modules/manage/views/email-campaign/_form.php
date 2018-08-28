<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailCampaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-campaign-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $model->isNewRecord ? $form->field($model, 'title')->textInput(['maxlength' => true]) : 
        $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ?>

    <?= $form->field($model, 'template_id')->dropDownList($templates) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
