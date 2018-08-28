<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * Created by PhpStorm.
 * User: Awsaf
 * Date: 5/28/2016
 * Time: 2:43 AM
 */

/* @var $this yii\web\View */

$this->title = 'Update All Prices';

?>
<div class="setting-update">

    <div class="setting-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'value')->textInput()->label('Pro Percent Value') ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>

</div>
