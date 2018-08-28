<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accessory */

$this->title = 'Update Accessory: ' . ' ' . $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Accessories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accessory-update">

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
