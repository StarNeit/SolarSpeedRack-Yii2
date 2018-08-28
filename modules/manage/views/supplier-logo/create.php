<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SupplierLogo */

$this->title = 'Create Supplier Logo';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Logos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-logo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
