<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\ZipcodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zip Codes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zip-code-index">

    
    <p>
        <?= Html::a('Create Zip Code', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import CA Zip Code', ['importca'], ['class' => 'btn btn-info']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'code',
            'city',
            'state',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>

</div>
