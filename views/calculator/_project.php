<?php
use yii\helpers\Html;

?>
<div class="item col-md-6">
    <div class="ptitle">
        <?= $model->name ?> &nbsp;
        <?= Html::a('<i class="fa fa-cog"></i>&nbsp;&nbsp;Update', [
                                '/calculator/' . $model->id
                            ], [
                                'class'=>'btn btn-default',
                            ]); ?>
        <span class="pull-right"><?= $model->id ?></span>
    </div>
    <div class="row pdesc">
        <div class="col-sm-6">
            <p><b>City: </b> <?= $model->zip ? $model->zip->city : ''?> </p>
            <p><b>State: </b> <?= $model->zip ? $model->zip->state : '' ?> </p>
            <p><b>Zip Code: </b> <?= $model->zip ? $model->zip_code : '' ?> </p>
        </div>
        <div class="col-sm-6">
            <p><b>Total Watts: </b> <?= $model->total_watt ?></p>
            <p><b>Total Materials: </b><?= $model->total_material ?></p>
            <p><b>Cost Per Watt: </b>$ <?= Yii::$app->formatter->asDecimal($model->cost_per_watt,2) ?></p>
            <p>
                <!--< Html::a(Html::img('/images/icons/pdf.png'), "/files/pdf/project-$model->id.pdf", ['target'=>'_blank']) ?>-->
                <!--< Html::a(Html::img('/images/icons/csv.png'), "/files/csv/project-$model->id.csv", ['target'=>'_blank']) ?>-->
                <!--< Html::a(Html::img('/images/icons/cad.png'), "/files/cad/project-$model->id.dxf", ['target'=>'_blank']) ?>-->
            </p>
        </div>
    </div>
</div>
<?php 
if($index > 0 && ($index + 1) % 2 == 0) {
    echo '</div><hr /><div class="row">';
}