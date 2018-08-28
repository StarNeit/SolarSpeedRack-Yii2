<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ZipCode */

$this->title = 'Update MetaData';
?>
<div class="zip-code-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_meta', [
        'model' => $model,
    ]) ?>

</div>
