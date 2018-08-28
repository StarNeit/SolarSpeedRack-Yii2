<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EmailCampaign */

$this->title = 'Update Email Campaign: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Email Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="email-campaign-update">

    <?= $this->render('_form', [
        'model' => $model,
        'templates' => $templates
    ]) ?>

</div>
