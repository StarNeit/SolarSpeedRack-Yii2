<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductPackage */
/* @var $form yii\widgets\ActiveForm */
if ($model->code == 'FREE') {
    $a = '$(".pcode").slideUp();';
} else {
    $a = '';
}

$this->registerJs($a . '
    $(\'input[name="is_membership_offer"]\').change(function(){
    if($(\'input[name="is_membership_offer"]:checked\').val()) { 
        $(".pcode").slideUp();
        $("#productpackage-code").val("FREE");
        $("#productpackage-required_id").val(1);
        $("#productpackage-required_qty").val(1);
    } else {
        $(".pcode").slideDown();
        $("#productpackage-code").val("");
        $("#productpackage-required_id").val("");
        $("#productpackage-required_qty").val("");
    }
});
    $(\'input[name="sale_qty_same"]\').change(function(){
    if($(\'input[name="sale_qty_same"]:checked\').val()) { 
        $(".pcode").slideUp();
        $("#productpackage-code").val("FREE");
        $("#productpackage-required_id").val(1);
        $("#productpackage-required_qty").val(1);
    } else {
        $(".pcode").slideDown();
        $("#productpackage-code").val("");
        $("#productpackage-required_id").val("");
        $("#productpackage-required_qty").val("");
    }
});
');
?>

<div class="product-package-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= Html::checkbox('is_membership_offer', $model->code == 'FREE' ? TRUE : FALSE, ['label' => 'Free With Membership']) ?>

            <?= $form->field($model, 'sale_id')->textInput() ?>

            <?= $form->field($model, 'sale_amount')->textInput(['maxlength' => true]) ?>

            <?php // $form->field($model, 'sale_apply_qty')->textInput(['maxlength' => true]) ?>

            <label>Required Quantity of Sale Product</label>
            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'sale_qty_same')->checkbox() ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'sale_qty')->textInput(['maxlength' => true])->label('') ?>
                </div>
            </div>

            <?=
            $form->field($model, 'sale_start', ['options' => ['class' => 'form-group']])->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
                    ], ['class' => 'form-control'])
            ?>

            <?=
            $form->field($model, 'sale_end', ['options' => ['class' => 'form-group']])->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
                    ], ['class' => 'form-control'])
            ?>

            <?= $form->field($model, 'status')->dropDownList(\app\helpers\PHelper::statusOption()) ?>
        </div>

        <div class="col-md-6 pcode">
            <?= $form->field($model, 'code')->textInput()->hint('Do Not use FREE as Code') ?>

            <?= $form->field($model, 'required_id')->textInput() ?>

            <?= $form->field($model, 'required_qty')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
