<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('$("#product-category_id").change(function(){
var val = $(this).val();
$.get("/site/get?alias=subcat&cat="+val, function(data) {
    $("#product-sub_category_id").html(data);
});
});
if(!$("#product-need_shipping").is(":checked")) {
    $(".ship").hide();
}
$("#product-need_shipping").change(function(){
if($("#product-need_shipping").is(":checked")) {
    $(".ship").slideDown();
} else {
    $(".ship").slideUp();
}
});
');


?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'manufacturer_id')->widget('dosamigos\selectize\SelectizeDropDownList', [
                'model' =>$model,
                'attribute' => 'manufacturer_id',
                'items' => \app\models\Manufacturer::listAll(),
                'clientOptions' => [
                ],
            ]); ?>
        </div>
    </div>
    
    <?= $form->field($model, 'features')->widget(CKEditor::className(),[
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' =>
            ElFinder::ckeditorOptions('elfinder',[
                'inline' => false,
                'resize_enabled' => true
            ]),
    ]) ?>
    
    <?= $form->field($model, 'specifications')->widget(CKEditor::className(),[
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' =>
            ElFinder::ckeditorOptions('elfinder',[
                'inline' => false,
                'resize_enabled' => true
            ]),
    ]) ?>
    
    <div class="row">
        <div class="col-md-6">
            <p><?= $model->product_link ? Html::a('link', $model->product_link, ['target'=>'_blank']) : '' ?></p>
            
            <?= $form->field($model, 'available_stock', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => 6]) ?>
            
            <?= $form->field($model, 'estimated_handling_time', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'note', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($meta, 'frame_color', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList([
                'Black' => 'Black',
                'Mill' => 'Mill',
                'White' => 'White',
                'Silver (Natural)' => 'Silver (Natural)',
                    ], ['prompt'=>'Select']); ?>
            
            <?= $form->field($model, 'manufacturer_product_code', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'code', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

            <div class="ship">
                <?= $form->field($meta, 'length', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                <?= $form->field($meta, 'width', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                <?= $form->field($meta, 'height', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                <?= $form->field($meta, 'weight', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                <?= $form->field($meta, 'rated_power', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                <?//= $form->field($meta, 'cell_technology_id', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\CellTech::listAll(), ['prompt'=>'--Select--']); ?>

                <?= $form->field($meta, 'quantity_per_box', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                <?= $form->field($meta, 'box_weight', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>
            </div>
            <?= $form->field($model, 'category_id', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\ProductCategory::listAll()) ?>
            
            <?php if($model->isNewRecord || $model->sub_category_id < 1) {
                echo $form->field($model, 'sub_category_id', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList([0=>'Select a Category First']);
            } else {
                echo $form->field($model, 'sub_category_id', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList([$model->sub_category_id=>$model->subcategory->name]);
            } ?>
            
            <div class="form-group col-md-12 col-lg-6">
                <?= $form->field($model, 'pdfFile', ['options'=>['class' => 'col-md-12']])->fileInput() ?>

                <?php if(!$model->isNewRecord && $model->pdf != '') { ?>
                <div class="col-md-12">
                    <a href="<?= $model->getFileUrl('pdf') ?>" target="_blank"><?= $model->pdf ?></a>
                    <span class="pull-right">
                        <?= Html::a('X', ['del-file', 'type'=>'pdf', 'id'=>$model->id], ['data-confirm'=>'Are you sure?']) ?>
                    </span>
                </div>
                <?php } ?>
            </div>
            <div class="form-group col-md-12 col-lg-6">
                <?= $form->field($model, 'pdfFile2', ['options'=>['class' => 'col-md-12 ']])->fileInput() ?>

                <?php if(!$model->isNewRecord && $model->pdf2 != '') { ?>
                <div class="col-md-12">
                    <a href="<?= $model->getFileUrl('pdf', 2) ?>" target="_blank"><?= $model->pdf2 ?></a>
                    <span class="pull-right">
                        <?= Html::a('X', ['del-file', 'type'=>'pdf', 'no'=>2, 'id'=>$model->id], ['data-confirm'=>'Are you sure?']) ?>
                    </span>
                </div>
                <?php } ?>
            </div>
            <div class="form-group col-md-12 col-lg-6">
                <?= $form->field($model, 'pdfFile3', ['options'=>['class' => 'col-md-12']])->fileInput() ?>

                <?php if(!$model->isNewRecord && $model->pdf3 != '') { ?>
                <div class="col-md-12">
                    <a href="<?= $model->getFileUrl('pdf', 3) ?>" target="_blank"><?= $model->pdf3 ?></a>
                    <span class="pull-right">
                        <?= Html::a('X', ['del-file', 'type'=>'pdf', 'no'=>3, 'id'=>$model->id], ['data-confirm'=>'Are you sure?']) ?>
                    </span>
                </div>
                <?php } ?>
            </div>
            <div class="form-group col-md-12 col-lg-6">
                <?= $form->field($model, 'cadFile', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->fileInput() ?>

                <?php if(!$model->isNewRecord && $model->cad != '') { ?>
                <div class="col-md-12 ">
                    <a href="<?= $model->getFileUrl('cad') ?>" target="_blank"><?= $model->cad ?></a>
                    <span class="pull-right">
                        <?= Html::a('X', ['del-file', 'type'=>'cad', 'id'=>$model->id], ['data-confirm'=>'Are you sure?']) ?>
                    </span>
                </div>
            <?php } ?>
            </div>

            <?= $form->field($model, 'youtube', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\Product::statusOption()) ?>
            <div class="ship">
                <?//= $form->field($model, 'handling_id', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\HandlingConfig::listOptions()) ?>
            </div>
        </div>
        <div class="col-md-6">
            <?php if($model->isNewRecord) { ?>
            <?php } else {
                    echo '<table class="table table-bordered"><thead><th>Qty From</th><th>Qty To</th><th>Price</th><th>Sale Price</th></thead><tbody>';
                    foreach ($model->prices as $price) {
                        if($price->max == 0) {
                            echo '<tr><td>' . $price->min . '+</td><td>&nbsp;</td><td>' . $price->price . '</td><td>' . $price->sale_price . '</td>'
//                                    . '<td>' . 
//                                    Html::a('Update', ['product/update-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-info']) . ' ' .
//                                    Html::a('Delete', ['product/del-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-danger']) . '</td>'
                                    . '</tr>';
                        } else {
                            echo '<tr><td>' . $price->min . '</td><td>' . $price->max . '</td><td>' . $price->price . '</td><td>' . $price->sale_price . '</td>'
//                                    . '<td>' . 
//                                    Html::a('Update', ['product/update-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-info']) . ' ' .
//                                    Html::a('Delete', ['product/del-price', 'id'=>$price->id], ['class'=>'btn btn-xs btn-danger']) . '</td>'
                                    . '</tr>';
                        }
                    }
                    echo '</tbody></table>';
                    echo Html::a('Update Prices', ['price', 'id' => $model->id], ['class' => 'btn btn-primary']);
                } ?>
            <hr />
            <div class="row">
                <?= $form->field($model, 'on_sale', ['options'=>['class' => 'form-group col-md-12 col-lg-4']])->checkbox() ?>

                <?= $form->field($model, 'sale_start', ['options'=>['class' => 'form-group col-md-12 col-lg-4']])->widget(\yii\jui\DatePicker::classname(), [
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>
                <?= $form->field($model, 'sale_end', ['options'=>['class' => 'form-group col-md-12 col-lg-4']])->widget(\yii\jui\DatePicker::classname(), [
                    'dateFormat' => 'yyyy-MM-dd',
                ]) ?>
            </div>
            <?= $form->field($model, 'need_shipping', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>
            
            <?= $form->field($model, 'free_shipping', ['options'=>['class' => 'ship form-group col-md-12 col-lg-6']])->checkbox() ?>
            
            <div class="row">
                <div class="ship">
            
                    <?= $form->field($model, 'nmfc', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'package_type', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\Product::listPackageType()) ?>

                    <?= $form->field($model, 'class', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'hazardous', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList([0=>'No', 1=>'Yes']) ?>

                    <?= $form->field($model, 'commodity_type', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\Product::listCommodity()) ?>

                    <?= $form->field($model, 'content_type', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->dropDownList(\app\models\Product::listContents()) ?>
                </div>
                
                <?= $form->field($model, 'need_tax', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>

                <?= $form->field($model, 'calculate_per_foot', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>

                <?= $form->field($model, 'is_inverter', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>

                <?= $form->field($model, 'is_roof_attachment', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>

                <?= $form->field($model, 'shared_compatible', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>

                <?= $form->field($model, 'standard_compatible', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->checkbox() ?>

                <?= $form->field($model, 'minimum_order', ['options'=>['class' => 'form-group col-md-12 col-lg-6']])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'imageFiles[]', ['options'=>['class' => 'form-group ']])->fileInput(['multiple' => true]) ?>

    <?php if(!$model->isNewRecord && !empty($model->images)) { ?>
       <div class="form-group row">
    <?php foreach ($model->images as $img) {
           ?>
           <div class="col-sm-3 col-xs-4">
               <a href="/uploads/images/<?= $img->id . '-' . $img->created_by . '.' . $img->extension ?>" download="<?= $img->file_name ?>">
                   <?= Html::img('/uploads/images/' . $img->id . '-' . $img->created_by . '.' . $img->extension, ['class'=>'img-responsive']) ?>
               </a>
                <br />
                <p class="text-center">
                    <?= Html::a('Delete', ['del-img', 'id'=>$img->id], ['data' => [
                                    'confirm' => 'Are you sure you want to delete this image?',
                                    'method' => 'post',
                                ]]) ?>
                </p>
           </div>
       <?php } ?>
       </div>
    <?php   } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
