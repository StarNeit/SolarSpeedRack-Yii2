<?php 
$this->title = Yii::t('app', 'My Projects');

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;



?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <?php if($member && $member->company->hasImage()) :
                    echo Html::img($member->company->getUrl('preview'), ['class'=>'img-responsive img-rounded pro-img']);
                    else :
                    echo Html::img('/images/no-image.jpg', ['class'=>'img-responsive img-rounded pro-img']);
                    endif; ?>
                <h1>
                    My Projects
                </h1>
                <p><?= $member ? $member->company->name : ''?></p>
            </div>
            <div class="col-sm-6 search-box">
                <p>&nbsp;</p>
                <?php $form = ActiveForm::begin([
                    'action' => '/calculator/my-projects',
                    'layout' => 'inline',
                    'method' => 'get',
                ]); ?>

                <?= $form->field($searchModel, 'name', [
                        'inputTemplate' => '<div class="input-group">{input}<div class="input-group-addon">' .
                                            Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-grey']) .
                                            '</div></div>',
                    ])->input('text', ['placeholder'=>'Project Name']) ?>


                <?php ActiveForm::end(); ?>
                <br />
                <p>
                    <?= Html::a(Yii::t('app', 'Create New Project'), ['new'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-th-list"></i>', ['my-projects'], ['class' => 'btn btn-success disabled']) ?> &nbsp;
                    <?= Html::a('<i class="fa fa-th"></i>', ['my-projects-grid'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
        <hr />
        <div class="product-index">
            <h3 class="text-center">Open Projects</h3>
            <?= ListView::widget([
                'dataProvider' => $openDataProvider,
                'layout'=>'{items}<br />{pager}',
                'options' => ['class' => 'row'],
                'itemOptions' => ['tag' => false],
                'itemView' => '_project',
            ]) ?>

        </div>
        <div class="product-index">
            <hr />
            <h3 class="text-center">Close Projects</h3>
            <?= ListView::widget([
                'dataProvider' => $closeDataProvider,
                'layout'=>'{items}<br />{pager}',
                'options' => ['class' => 'row'],
                'itemOptions' => ['tag' => false],
                'itemView' => '_closed-project',
            ]) ?>

        </div>
    </div>
</section>