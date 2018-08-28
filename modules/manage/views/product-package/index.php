<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\ProductPackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Packages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-package-index">

    <p>
        <?= Html::a('Create Product Package', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            'sale_id',
            'required_id',
//            'sale_type',
//            'sale_percent',
             'sale_amount',
            // 'required_qty',
            // 'sale_start',
            // 'sale_end',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
