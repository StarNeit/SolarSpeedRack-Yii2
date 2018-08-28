<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\EmailCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-campaign-index">
    <p>
        <?= Html::a('Create Email Campaign', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'template_id',
                'value'=> 'template.name',
                'header'=> 'Template',
                'filter'=>false
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update}'
                ],
        ],
    ]); ?>

</div>
