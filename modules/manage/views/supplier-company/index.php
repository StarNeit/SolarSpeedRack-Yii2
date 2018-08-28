<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\SupplierCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supplier Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-company-index">

    <p>
        <?= Html::a('Create Supplier Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'email',
//            'created_by',
//            'updated_by',
//            'created_at',
            // 'updated_at',
            // 'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}'
            ],
        ],
    ]); ?>

</div>
