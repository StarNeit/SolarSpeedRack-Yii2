<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailConfig */

$this->title = 'Create Email Config';
$this->params['breadcrumbs'][] = ['label' => 'Email Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-config-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
