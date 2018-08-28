<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\SupplierLogoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supplier Logos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-logo-index">

    <p>
        <?= Html::a('Create Supplier Logo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'link',
            'title',
            [
                'attribute'=> 'status',
                'value'=> function($model) {
                    return \app\helpers\PHelper::statusOption($model->status);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'
            ],
        ],
    ]); ?>

</div>
