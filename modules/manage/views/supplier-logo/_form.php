<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierLogo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-logo-form">
    <div class="row">
        <div class="col-sm-7">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList(\app\helpers\PHelper::statusOption()) ?>
        </div>
        <div class="col-sm-5">
            <?=  \zxbodya\yii2\imageAttachment\ImageAttachmentWidget::widget(
                        [
                            'model' => $model,
                            'behaviorName' => 'image',
                            'apiRoute' => '/site/slogos',
                        ]
                    ) 
                ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
