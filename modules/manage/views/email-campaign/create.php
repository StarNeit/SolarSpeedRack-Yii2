<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailCampaign */

$this->title = 'Create Email Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Email Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-campaign-create">

    <?= $this->render('_form', [
        'model' => $model,
        'templates' => $templates
    ]) ?>

</div>
