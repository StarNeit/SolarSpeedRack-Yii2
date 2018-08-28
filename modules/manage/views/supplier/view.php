<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Supplier */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'company_id',
                'value' => $model->company->name
            ],
            [
                'label' => 'Full Name',
                'value' =>$model->user->profile->first_name . ' ' .$model->user->profile->last_name
            ],
            [
                'label' => 'Address',
                'value' =>$model->user->profile->street_address
            ],
            [
                'label' => 'Address (Line 2)',
                'value' =>$model->user->profile->street_address2
            ],
            [
                'label' => 'City',
                'value' =>$model->user->profile->city
            ],
            [
                'label' => 'State',
                'value' =>$model->user->profile->state
            ],
            [
                'label' => 'Zip',
                'value' =>$model->user->profile->zip
            ],
            [
                'label' => 'Office Number',
                'value' =>$model->user->profile->phone_number
            ],
            [
                'label' => 'Contact Number',
                'value' =>$model->user->profile->phone_number2
            ],
            [
                'attribute' => 'type',
                'value' => $model->type == 1 ? 'Admin' : 'Staff'
            ],
            'requested_categories',
            [
                'attribute' => 'status',
                'value' => \app\helpers\PHelper::statusOption($model->status)
            ],
        ],
    ]) ?>


</div>
