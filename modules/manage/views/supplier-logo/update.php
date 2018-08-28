<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierLogo */

$this->title = 'Update Supplier Logo: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Supplier Logos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="supplier-logo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
