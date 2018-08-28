<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Project Details');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Project Details'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
                ],

//            'id',
            'project.name',
            'customer.username',
            'installer.username',
            'inspection_date',
            // 'inspection_time:datetime',
            // 'inspection_detail:ntext',
            // 'installation_date',
            // 'installation_time:datetime',
            // 'installation_detail:ntext',
            // 'inspection_status',
            // 'customer_confirmation',
            // 'permit_plan_status',
            // 'products_shipped',
            // 'completion_form_submitted',
            // 'permit_plan_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
