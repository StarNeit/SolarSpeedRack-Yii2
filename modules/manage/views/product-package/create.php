<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductPackage */

$this->title = 'Create Product Package';
$this->params['breadcrumbs'][] = ['label' => 'Product Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-package-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
