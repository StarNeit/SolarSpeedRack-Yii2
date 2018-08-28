<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SMConfigurationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Projects');

?>
<section class="section">
    <div class="smconfiguration-index">

        <div class="row">
            <div class="col-sm-6">
                <?php if($member && $member->company->hasImage()) :
                    echo Html::img($member->company->getUrl('preview'), ['class'=>'img-responsive img-rounded pro-img']);
                    else :
                    echo Html::img('/images/no-image.jpg', ['class'=>'img-responsive img-rounded pro-img']);
                    endif; ?>
                <h1>
                    My Projects
                </h1>
                <p><?= $member ? $member->company->name : ''?></p>
            </div>
            <div class="col-sm-6 search-box">
                <p>&nbsp;</p>
                <?php $form = ActiveForm::begin([
                    'action' => '/calculator/my-projects-grid',
                    'layout' => 'inline',
                    'method' => 'get',
                ]); ?>

                <?= $form->field($searchModel, 'name', [
                        'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon">' .
                                            Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-grey']) .
                                            '</div></div>',
                    ])->input('text', ['placeholder'=>'Project Name']) ?>


                <?php ActiveForm::end(); ?>
                <br />
                <p>
                    <?= Html::a(Yii::t('app', 'Create New Project'), ['new'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-th-list"></i>', ['my-projects'], ['class' => 'btn btn-success ']) ?> &nbsp;
                    <?= Html::a('<i class="fa fa-th"></i>', ['my-projects-grid'], ['class' => 'btn btn-success disabled']) ?>
                </p>
            </div>
        </div>
        <hr />

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'name',
                [
                    'format'=>'raw',
                    'header'=>'City',
                    'value'=> function($model) {
                        return $model->zip ? $model->zip->city : '';
                    }
                ],
                [
                    'format'=>'raw',
                    'header'=>'State',
                    'value'=> function($model) {
                        return $model->zip ? $model->zip->state : '';
                    }
                ],
                [
                    'format'=>'raw',
                    'header'=>'Zip Code',
                    'value'=> function($model) {
                        return $model->zip_code;
                    }
                ],
                [
                    'attribute' => 'last_updated',
                    'filter' => false,
                    'value' => function($model) {
                        return Yii::$app->formatter->asDatetime($model->updated_at);
                    }
                ],
                [
                    'format'=>'raw',
                    'value'=> function($model) {
                        return Html::a('<i class="fa fa-cog"></i>', [
                                    '/calculator/' . $model->id
                                ], [
                                    'class'=>'btn btn-info btn-sm',
                                ]) . ' ' .
                            Html::a('<i class="fa fa-trash"></i>', [
                                    '/calculator/delete',
                                    'id'=>$model->id
                                ], [
                                    'data' => [
                                        'method'=> 'post',
                                        'confirm'=> 'Are you sure you want to delete this Project?'
                                    ],
                                    'class'=>'btn btn-info btn-sm',
                                ]);
                    }
                ]
                // 'max_span',
                // 'roof_type',
                // 'roof_pitch',
                // 'wind_exposer',
                // 'use_sfoot',
                // 'use_ibracket',
                // 'span_length',
                // 'building_code',
                // 'wind_speed',
                // 'snow_load',
                // 'zip_code',
                // 'condition',
                // 'exposer_type',
                // 'wind_zone_type',
                // 'last_updated',
                // 'models:ntext',
                // 'created_by',
                // 'updated_by',
                // 'status',

    //            ['class' => 'yii\grid\ActionColumn' ],
            ],
        ]); ?>

    </div>
</section>