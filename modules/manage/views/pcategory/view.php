<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductCategory */

$this->title = 'Category : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

    <?php 
    echo '<table class="table table-bordered"><thead><th>Qty From</th><th>Name</th><th></th></thead><tbody>';
    foreach ($model->subs as $sub) {
        echo '<tr><td>' . $sub->name . '</td><td>' . 
                Html::a('update', ['pcategory/update-sub', 'id'=>$sub->id], ['class'=>'btn btn-xs btn-info']) . ' ' . 
                Html::a('Delete', ['pcategory/del-sub', 'id'=>$sub->id], ['class'=>'btn btn-xs btn-danger']) . 
                '</td></tr>';
    }
    echo '</tbody></table><hr />';
    ?>
    
    <h2>Add Sub Category</h2>
    <hr />
    <?php $form = ActiveForm::begin(['layout'=>'inline', 'action'=>['pcategory/add-sub', 'id'=>$model->id]]); ?>

    <?= $form->field($newsub, 'name')->textInput(['maxlength' => true, 'placeholder'=>'Name']) ?>

    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
