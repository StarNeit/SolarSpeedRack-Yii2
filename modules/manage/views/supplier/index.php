<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'filterModel' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'user_id',
                'label' => 'Username',
                'format' =>'raw',
                'value' => function($model) {
                    return Html::a($model->user->username, ['/user/admin/update', 'id'=>$model->user_id]);
                }
            ],
            [
                'attribute' => 'type',
                'label' => 'Role',
                'value' => function($model) {
                    return $model->type == 1 ? 'Admin' : 'Staff';
                }
            ],
            [
                'attribute' => 'company_id',
                'label' => 'Company',
                'format' =>'raw',
                'value' => function($model) {
                    return Html::a($model->company->name, ['/manage/supplier-company/view', 'id'=>$model->company_id]);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return \app\helpers\PHelper::statusOption($model->status);
                }
            ],
            'requested_categories',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            // 'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
