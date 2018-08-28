<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Accessory */

$this->title = 'Create Accessory';
$this->params['breadcrumbs'][] = ['label' => 'Accessories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accessory-create">

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>
