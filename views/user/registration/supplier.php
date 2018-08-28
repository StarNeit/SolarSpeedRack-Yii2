<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use dosamigos\selectize\SelectizeDropDownList;

/* @var $this yii\web\View */
/* @var $model app\models\MemberSignUpForm */
/* @var $form ActiveForm */

$this->title = 'Sign Up';
$this->params['subTitle'] = 'Form';

?>
<h1 class="text-center">Supplier Application</h1>
<br />
<div class="user-registration-member">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data'], 'layout'=>'horizontal']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($company, 'name', ['template'=>'{label}<div class="col-sm-6">{input}{hint}{error}</div>'])->label('Company Name')->textInput(['placeholder'=>'Company Name']) ?>
            
            <?= $form->field($company, 'email', ['template'=>'{label}<div class="col-sm-6">{input}{hint}{error}</div>'])->label('Company Email')->textInput(['placeholder'=>'Company Email']) ?>
            
            <div class="form-group field-address-first_name">                
                <label class="control-label col-sm-3" for="address-first_name">Full Name</label>
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'first_name', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'First Name']) ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'last_name', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'Last Name']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group field-address-first_name">                
                <label class="control-label col-sm-3">Address</label>
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'address1', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'Street Address']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'address2', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'Street Address Line 2']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'city', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'City']) ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'state', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'State / Province']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'zip_code', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'Postal / Zip Code']) ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <?= $form->field($address, 'country', ['template'=>"{input}\n{hint}\n{error}"])->textInput(['placeholder'=>'Country']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['placeholder'=>'ex: yourmail@example.com']) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'******']) ?>
            <?= $form->field($model, 'verifyPassword')->passwordInput(['placeholder'=>'******']) ?>
            <?= $form->field($address, 'office_number')->textInput(['placeholder'=>'Area Code - Phone Number']) ?>
            <?= $form->field($address, 'contact_number')->textInput(['placeholder'=>'Area Code - Phone Number']) ?>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4">
            <h3 style="margin: 0 0 15px 0;">Product Type</h3>
            <p>Please select the type of product your 
                company offers</p>
            <p>For multiple product selection, hold the Ctrl 
                button and click on the products you offer</p>
            <!--<div class="col-sm-12">-->

                <?= SelectizeDropDownList::widget([
                    'model' => $supplier,
                    'attribute' => 'requests[]',
                    'items' => \app\models\ProductCategory::getAll(),
                    'value' => [],
                    'options'=> [
                        'placeholder'=> 'Select Your Product'
                    ],
                    'clientOptions' => [
                        'plugins' => ['remove_button', 'restore_on_backspace'],
                        'create' => true,
                        'maxItems' => 10,
                        'items' => []
                    ],
                ]);  ?>
            <!--</div>-->
        </div>
        <div class="col-sm-4 captcha-group">
            <label class="control-label">Logo (Optional)</label>
            <br />
            <br />
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?= $form->field($model, 'logo', ['template'=>"{input}{hint}{error}"])->fileInput(); ?>
                </div>
            </div>
            
        </div>
        <div class="col-sm-4 text-center">
            <div class="captcha-group">
                <?= $form->field($model, 'verifyCode', ['template'=>'<div class="capt">{input}</div>{error}'])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
            </div>
            <div class="form-actions">
                <?= Html::submitButton('Submit', ['class' => 'btn subbtn btn-grey']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-registration-member -->
<?php
$this->registerJs(
'
    jQuery("#supplier-requests")[0].selectize.clear();
        $("#supplieraddress-zip_code").keyup(function(){
            if($(this).val().length >= 5) {
                $.get("/site/zip?code="+$(this).val(), function(data) {
                    if(data.city) {
                        $("#supplieraddress-city").val(data.city);
                        $("#supplieraddress-state").val(data.state);
                    }
                }, "json")
            }
        });
    ');