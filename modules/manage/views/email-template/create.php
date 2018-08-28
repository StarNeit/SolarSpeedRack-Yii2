<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailTemplate */

$this->title = 'Create Email Template';
$this->params['breadcrumbs'][] = ['label' => 'Email Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
