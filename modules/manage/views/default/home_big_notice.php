<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\models\Setting */

$this->title = 'Update Homepage Notice';

?>
<div class="setting-update">

    <div class="setting-form">

        <?php $form = ActiveForm::begin(); ?>
        
        <?= $form->field($model, 'value')->widget(CKEditor::className(),[
            'options' => ['rows' => 6],
            'preset' => 'full',
            'clientOptions' =>
                ElFinder::ckeditorOptions('elfinder',[
                    'inline' => false,
                    'resize_enabled' => true
                ]),
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>