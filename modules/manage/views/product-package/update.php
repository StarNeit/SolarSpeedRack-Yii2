<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductPackage */

$this->title = 'Update Product Package: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-package-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
