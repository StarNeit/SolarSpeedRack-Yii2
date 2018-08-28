<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\AccessorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accessories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accessory-index">

<!--    <p>
         Html::a('Create Accessory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'slug',
            'description',
            'order',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>

</div>
