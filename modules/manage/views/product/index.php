<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'manufacturer_product_code',
            'available_stock',
            // 'length',
            // 'width',
            // 'height',
            // 'gross_weight_per_lbs',
            // 'quantity_per_box',
            // 'box_gross_weight',
            // 'msrp',
            // 'single_pro_discount',
            // 'single_elite_discount',
            // 'double_pro_discount',
            // 'double_elite_discount',
            // 'nmfc',
            // 'package_type',
            // 'category_id',https://www.upwork.com/signup/contact-contractor/id/~0150d9773ad78a28c3/va/cpp
            // 'pdf',
            // 'cad',
            // 'youtube',
            // 'rating',
            // 'class',
            // 'hazardous',
            // 'commodity_type',
            // 'content_type',
            // 'created_by',
            // 'updated_by',
            // 'created_at',
            // 'updated_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
