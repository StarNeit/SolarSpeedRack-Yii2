<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="panel panel-info">
    <div class="panel-heading  navigation__title text-center"> 
        Assign for Inspection 
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'rowOptions' => function ($model) {
                if ($model->inspection_status == 2) {
                    return ['class' => 'info'];
                }
            }
                    ,
                    'id' => 'inspection-projects',
                    'dataProvider' => $inspection_dataProvider,
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
                                return date('d-m-Y', strtotime($data->inspection_date));
                            },
                        ],
//               
                        [
                            'label' => 'Time',
                            'value' =>
                            function ($data) {
                                return date("H:i", $data->inspection_time);
                            },
                        ],
                        [
                            'label' => 'Inspection Status',
                            'value' =>
                            function ($data) {
                                return $data->getInspectionStatus();
                            },
                        ],
//               
//                            'project.name',
//                    'customer.username',
//                    'installer.username',
//                    'inspection_date',
                        // 'inspection_engrasadetime:datetime',
                        // 'inspection_detail:ntext',
//                 'installation_date',
//                 'installation_time:datetime',
                        // 'installation_detail:ntext',
//                    'inspection_status',
//                    'customer_confirmation',
//                     'permit_plan_status',
//                     'products_shipped',
//                     'completion_form_submitted',
//                     'permit_plan_id',
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{view}{update}',
//                    ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{confirm}{-}{change}{assign}',
                            'visibleButtons' => [
                                'confirm' => function ($model, $key, $index) {
                                    return $model->inspection_status === 2 ? false : true;
                                },
                                'change' => function ($model, $key, $index) {
                                    return $model->inspection_status === 2 ? false : true;
                                },
                                        'assign' => function ($model, $key, $index) {
                                    return $model->inspection_status === 2 ? true : false;
                                },
                            ],
                            'buttons' => [
                                'confirm' => function ($url, $model) {

                                    return Html::a('<span class="glyphicon  glyphicon-ok"></span>&nbsp;', $url, [
                                                'title' => Yii::t('yii', 'Confirm'),
                                    ]);
                                },
                                        'change' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon  glyphicon-edit"></span>', $url, [
                                                'title' => Yii::t('yii', 'Change'),
                                    ]);
                                },
                                            'assign' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-transfer"></span>', $url, [
                                                'title' => Yii::t('yii', 'Assign for Installation'),
                                    ]);
                                },
                                    ]
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?></div>



</div>

