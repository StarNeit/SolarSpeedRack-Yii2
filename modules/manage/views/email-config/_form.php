<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'default')->textInput() ?>

    <?= $form->field($model, 'from_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'replyto_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'replyto_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_emails')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
