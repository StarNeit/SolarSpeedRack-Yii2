<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SupplierCompany */

$this->title = 'Create Supplier Company';
$this->params['breadcrumbs'][] = ['label' => 'Supplier Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address'=> $address
    ]) ?>

</div>
