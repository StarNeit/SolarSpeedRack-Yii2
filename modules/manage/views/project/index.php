<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'zip_code',
            [
                'attribute'=> 'company_id',
                'filter'=>false,
                'label'=>'Company',
                'value' => function($model) {
                    return $model->company->name;
                }
            ],
            [
                'attribute'=> 'updated_at',
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at);
                }
            ],
//            'total_watt',
//            'total_material',
            // 'cost_per_watt',
            // 'cost_per_panel',
            // 'module_id',
            // 'inverter_id',
            // 'optimizer_id',
            // 'roof_attachment_id',
            // 'layout:ntext',
            // 'config:ntext',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'company_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-eye"></i> View', ['/tool/update', 'id'=>$model->id], ['class'=>'btn btn-xs btn-default', 'target'=>'_blank']);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
