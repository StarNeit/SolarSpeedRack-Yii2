<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ZipCode */

$this->title = 'Create Zip Code';
$this->params['breadcrumbs'][] = ['label' => 'Zip Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zip-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
