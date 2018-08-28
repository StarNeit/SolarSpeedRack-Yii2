<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email',
            [
                'attribute' => 'created_at',
                'value' => \Yii::$app->formatter->asDatetime($model->created_at)
            ],
            [
                'attribute' => 'status',
                'value' => \app\helpers\PHelper::statusOption($model->status)
            ],
        ],
    ]) ?>

</div>
