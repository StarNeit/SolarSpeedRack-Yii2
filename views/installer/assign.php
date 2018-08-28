<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Installer: Assign for Installation ');
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
                        <h1 class="text-muted text-center ui-accordion">Thanks for Inspection.</h1>
                        <br/>
                        <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
                        <div class="col-sm-offset-3">
                            <b>Project Name: </b> <?= $model->project->name ?> <br/>
                            <b>Customer Name: </b> <?= $model->customer->username ?> <br/>
                            <b>Customer Address: </b> <?= $model->customer->profile->first_name ?> <br/>


                        </div>
                        <br/>  <br/>

                        <?php
                        
                        $model->installation_time = date('H:i', $model->installation_time);
                        echo $form->field($model, 'installation_time')->widget(\janisto\timepicker\TimePicker::className(), [
                            //'language' => 'fi',
//                            'mode' => 'datetime',
                            'mode' => 'time',
                            'clientOptions' => [
//                                'dateFormat' => 'yy-mm-dd',
                                'timeFormat' => 'HH:mm',
                                'showSecond' => false,
                            ]
                        ]);
                        echo $form->field($model, 'installation_date')->widget(\yii\jui\DatePicker::classname(), [
                            //'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                            'options' => ["class" => "form-control"]
                        ]);

                        ?>
                        <?=
                                $form->field($model, 'installation_status')
                                ->dropDownList(
                                        [1=>'Not Done',2=>'In Progress',3=>'Complete']
                                )
                        ?>
                       

                        <?= $form->field($model, 'installation_detail')->textarea(['rows' => 6]) ?>
                        <div class="form-group text-center">
                            <?=
                            Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') :
                                            Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                            ?>
                        </div>



                        <?php ActiveForm::end(); ?>


                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
