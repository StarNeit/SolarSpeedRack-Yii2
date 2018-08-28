<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectDetails */

$this->title = $model->project->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Project Details'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'project_id',
            'customer_id',
            'installer_id',
            'inspection_date',
            'inspection_time:datetime',
            'inspection_detail:ntext',
            'installation_date',
            'installation_time:datetime',
            'installation_detail:ntext',
            'inspection_status',
            'customer_confirmation',
            'permit_plan_status',
            'products_shipped',
            'completion_form_submitted',
            'permit_plan_id',
        ],
    ]) ?>

</div>
