<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\manage\models\EmailConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-config-index">
    <p>
        Update the default email settings used for sending email's to users. 
        <!--< Html::a('Create Email Config', ['create'], ['class' => 'btn btn-success']) ?>-->
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            'id',
//            'default',
            'from_name',
            'from_email:email',
            'replyto_name',
            'replyto_email:email',
            // 'cc_emails:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>

</div>
