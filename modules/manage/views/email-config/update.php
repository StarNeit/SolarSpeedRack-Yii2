<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailConfig */

$this->title = 'Update Email Config: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Email Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-config-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
