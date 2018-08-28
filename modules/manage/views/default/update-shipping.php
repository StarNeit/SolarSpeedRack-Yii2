<?php 
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Shipping Option';
?>

<div class="update-shipping-form">

    <?php $form = ActiveForm::begin(['layout'=>'horizontal']); ?>

    <h3>Shipping Fee</h3>
        <?= $form->field($model, 'el')->radioList([
            1=>'Calculated', 
            2 => '% ' . $form->field($model, 'elp', ['template'=>'{input}'])->input('number')->inline()
            ])->label('Elite Membership') ?>
    
        <?= $form->field($model, 'pro')->radioList([
            1=>'Calculated', 
            2 => '% ' . $form->field($model, 'prop', ['template'=>'{input}'])->input('number')->inline()
            ])->label('Pro Membership') ?>
    
    
    <div class="form-group">
        <div class="col-lg-5 col-sm-offset-3">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
