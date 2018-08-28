<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectDetails */

$this->title = $model->project->name. " of ".$model->customer->username ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">

    <div class="panel-heading text-center">  
        <?= Html::encode($this->title) ?>
        <span class="pull-right"> <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </span>
    </div>
    <div class="panel-body">

<?php
$status=$model->inspection_status;
 $status= $status == 0 ? "warning" : ($status == 1 ? "success" : "error" );
?>
<div class="project-details-view">
 
    <table class="table table-bordered table-mc-light-green">
        <tr>
            <td> Inspection Date </td>   <td> <?= $model->inspection_date ?>  </td>
         </tr>
         <tr>
             <td> Inspection Time </td>   <td> <?= date("h:i:s",  strtotime($model->inspection_time)) ?>  </td>
         </tr> 
        <tr class="<?php echo $status  ?>">
              <td> Inspection Status </td>   <td> <?=  $model->getInspectionStatus()?>  </td>
        </tr>
        
         
    </table>
     <?php 
//        DetailView::widget([
//        'model' => $model,
//        'attributes' => [
////            'id',
////            'project_id',
////            'customer_id',
//            'installer_id',
//            'inspection_date',
//            'inspection_time:datetime',
//            'inspection_detail:ntext',
//            'installation_date',
//            'installation_time:datetime',
//            'installation_detail:ntext',
//            'inspection_status',
//            'customer_confirmation',
//            'permit_plan_status',
//            'products_shipped',
//            'completion_form_submitted',
//            'permit_plan_id',
//        ],
//    ]) 
//        ?>

</div>
</div>
</div>