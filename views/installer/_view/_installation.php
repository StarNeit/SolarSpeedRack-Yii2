<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="panel panel-success">
    <div class="panel-heading navigation__title text-center"> 
        Assign for Installation 
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'id' => 'installation-projects',
            'dataProvider' => $installation_dataProvider,
//        'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn'
                ],
//            'id',
                [
                    'label' => 'Project',
                    'value' => function ($data) {
                        return $data->project->name;
                    },
                ],
                [
                    'label' => 'Customer',
                    'value' =>
                    function ($data) {
                        return $data->customer->username;
                    },
                ],
                [
                    'label' => 'Date',
                    'value' =>
                    function ($data) {
                        return date('d-m-Y', strtotime($data->installation_date));
                    },
                ],
//               
                [
                    'label' => 'Time',
                    'value' =>
                    function ($data) {
                        return date("H:i", $data->installation_time);
                    },
                ],
                [
                    'label' => 'Installation Status',
                    'value' =>
                    function ($data) {
                        return $data->getInstallationStatus();
                    },
                ],
//                            'project.name',
//                    'customer.username',
//                    'installer.username',
//                    'inspection_date',
// 'inspection_engrasadetime:datetime',
// 'inspection_detail:ntext',
// 'installation_date',
// 'installation_time:datetime',
// 'installation_detail:ntext',
//                    'inspection_status',
//                    'customer_confirmation',
//                     'permit_plan_status',
//                     'products_shipped',
//                     'completion_form_submitted',
//                     'permit_plan_id',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?></div>



</div>



