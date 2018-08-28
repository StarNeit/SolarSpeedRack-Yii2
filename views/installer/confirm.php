<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Project Confirm');
$this->params['breadcrumbs'][] = $this->title;
?>
<hr/>
<div class="row">
    <div class="col-sm-offset-1 col-sm-10">

        <div class="panel panel-primary ">

            <div class="panel-heading text-center navigation__title">  
                <?= Html::encode($this->title) ?>

            </div>
            <div class="panel-body">



                <div class="row">
                    <div class="col-sm-10  col-sm-offset-1 text-sans-serif FontSmall">
                        <h1 class="text-muted text-center ui-accordion">Thanks for confirming your appointments.</h1>
                        <br/>
                        <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
                        <div class="col-sm-offset-3">
                            <b>Project Name: </b> <?= $model->project->name ?> <br/>
                        <b>Customer Name: </b> <?= $model->customer->username ?> <br/>
                        <b>Customer Address: </b> <?= $model->customer->profile->first_name ?> <br/>

                        <b>Inspection Date: </b> <?= date('d-m-Y', strtotime($model->inspection_date)); ?> <br/>
                        <b>Inspection Time: </b> <?= date("H:i", $model->inspection_time) ?> <br/>

 
                        </div>
                         <br/>  <br/>
                        <?= $form->field($model, 'inspection_detail')->textarea(['rows' => 6]) ?>
                        <div class="form-group text-center">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Confirm'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
