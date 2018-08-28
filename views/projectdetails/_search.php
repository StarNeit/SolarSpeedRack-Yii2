<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'installer_id') ?>

    <?= $form->field($model, 'inspection_date') ?>

    <?php // echo $form->field($model, 'inspection_time') ?>

    <?php // echo $form->field($model, 'inspection_detail') ?>

    <?php // echo $form->field($model, 'installation_date') ?>

    <?php // echo $form->field($model, 'installation_time') ?>

    <?php // echo $form->field($model, 'installation_detail') ?>

    <?php // echo $form->field($model, 'inspection_status') ?>

    <?php // echo $form->field($model, 'customer_confirmation') ?>

    <?php // echo $form->field($model, 'permit_plan_status') ?>

    <?php // echo $form->field($model, 'products_shipped') ?>

    <?php // echo $form->field($model, 'completion_form_submitted') ?>

    <?php // echo $form->field($model, 'permit_plan_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
