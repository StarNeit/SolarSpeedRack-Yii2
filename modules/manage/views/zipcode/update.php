<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ZipCode */

$this->title = 'Update Zip Code: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Zip Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zip-code-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
