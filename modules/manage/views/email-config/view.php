<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmailConfig */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Email Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-config-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'default',
            'from_name',
            'from_email:email',
            'replyto_name',
            'replyto_email:email',
            'cc_emails:ntext',
        ],
    ]) ?>

</div>
