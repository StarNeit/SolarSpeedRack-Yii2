<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ZipCode */

$this->title = 'Zip Code - ' . $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Zip Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zip-code-view">

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
    <div class="row">
        <div class="col-sm-4">
            <h3>Location</h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'city',
                    'state',
                ],
            ]) ?>
        </div>
        <div class="col-sm-8">
            <h3>Metadata</h3>
            <p>
                <?= Html::a('Create', ['create-meta', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
        //            ['class' => 'yii\grid\SerialColumn'],

                    [
                        'header'=>'Building Code',
                        'format'=>'html',
                        'value' => function($model) {
                            return $model->buildingCode;
                        }
                    ],
                    'wind',
                    'snow',
                    'seismic_ss',
                    'pk',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-meta', 'id'=>$model->id], [
                                        'class' => 'btn btn-info btn-sm',
                                    ]);
                                },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
