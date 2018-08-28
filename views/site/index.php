<?php
use app\assets\HomeAsset;

HomeAsset::register($this);
?>
<input type="hidden" value='<?php echo Yii::$app->request->baseUrl ?>' id="solarapi_endpoint">
<input type="hidden" value='<?=Yii::$app->request->getCsrfToken()?>' id="csrf_token">

<section class="section" id="section0">

    <?= Yii::$app->controller->renderPartial('_section0'); ?>

</section>


<section class="section" id="section1">

    <?= Yii::$app->controller->renderPartial('_section1'); ?>

</section>


<section class="section" id="section2">

    <?= Yii::$app->controller->renderPartial('_section2'); ?>

</section>


<section class="section" id="section3">
    
    <?= Yii::$app->controller->renderPartial('_section3',[
                    'model' => $profile,
                    'user' => $user
        ]); ?>
    
</section>



<section class="section" id="section4">

    <?= Yii::$app->controller->renderPartial('_section4'); ?>

</section>


<section class="section" id="section7">

    <?= Yii::$app->controller->renderPartial('_section9'); ?>

</section>


<section class="section fp-normal-scroll" id="section8">

    <?= Yii::$app->controller->renderPartial('_section10'); ?>

</section>


