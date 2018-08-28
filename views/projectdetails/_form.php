<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-details-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

<?= $form->field($model, 'project_id')->dropDownList(ArrayHelper::map(\app\models\Project::find()->where(['status' => 1])->all(), 'id', 'name'), [ 'prompt' => ' -- Select Project --']) ?>


<?= $form->field($model, 'customer_id')->dropDownList(ArrayHelper::map(\app\models\User::find()->where(['confirmed_at' => !NULL])->all(), 'id', 'username'), [ 'prompt' => ' -- Select Project --']) ?>



<?= $form->field($model, 'installer_id')->dropDownList(ArrayHelper::map(\app\models\User::find()->all(), 'id', 'username'), [ 'prompt' => ' -- Select Installer --']) ?>


    <?=
    $form->field($model, 'inspection_date')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ["class" => "form-control"]
    ])
    ?>


    <?= $form->field($model, 'inspection_time')->textInput() ?>

    <?= $form->field($model, 'inspection_detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'installation_date')->textInput() ?>

    <?= $form->field($model, 'installation_time')->textInput() ?>

    <?= $form->field($model, 'installation_detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'inspection_status')->textInput() ?>

    <?= $form->field($model, 'customer_confirmation')->textInput() ?>

    <?= $form->field($model, 'permit_plan_status')->textInput() ?>

    <?= $form->field($model, 'products_shipped')->textInput() ?>

<?= $form->field($model, 'completion_form_submitted')->textInput() ?>

        <?= $form->field($model, 'permit_plan_id')->textInput() ?>

    <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
