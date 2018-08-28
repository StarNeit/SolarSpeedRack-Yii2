<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\UserAsset;
use app\assets\FancyboxAsset;
/* @var $this yii\web\View */
/* @var $profile app\models\Profile */
/* @var $user app\models\User */
/* @var $form ActiveForm */

UserAsset::register($this);
FancyboxAsset::register($this);

$this->title = 'Membership Application';
?>
<div class="user-member">
    <div>
        <h1 class="text-center"><?= $this->title ?></h1>
        <br>
        <?php $form = ActiveForm::begin(['layout' => 'horizontal',
            //'enableAjaxValidation' => true,
            'options' => ['class' => 'clearfix '],
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-md-3',
                    'wrapper' => 'col-md-9',
                    'error' => '',
                    'hint' => '',
                ]
            ],]); ?>

        <div class="col-md-6">
            <?= $form->field($model, 'company_name')->textInput(['placeholder' => $model->getAttributeLabel('company_name')]) ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'first_name', [
                        'horizontalCssClasses' => [
                            'label' => 'col-md-6',
                            'wrapper' => 'col-md-6',
                            'offset' => '',
                        ]
                    ])
                        ->textInput(['placeholder' => $model->getAttributeLabel('first_name')])
                        ->label('Full Name') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'last_name', [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-md-12',
                            'offset' => '',
                        ]
                    ])
                        ->textInput(['placeholder' => $model->getAttributeLabel('last_name')])
                        ->label(false) ?>
                </div>
            </div>
            <?= $form->field($model, 'street_address')->textInput(['placeholder' => $model->getAttributeLabel('street_address')])->label('Address') ?>
            <?= $form->field($model, 'street_address2')->textInput(['placeholder' => $model->getAttributeLabel('street_address2')])->label(false) ?>
            <div class="row">
                <div class="col-md-offset-3 col-md-4">
                    <?= $form->field($model, 'city', [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-md-12',
                            'offset' => '',
                        ]
                    ])->textInput(['placeholder' => $model->getAttributeLabel('city')])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'state', [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-md-12',
                            'offset' => '',
                        ]
                    ])->dropDownList(\app\models\Profile::usaStatesList())->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3  col-md-4">
                    <?= $form->field($model, 'zip', [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-md-12',
                            'offset' => '',
                        ]
                    ])->textInput(['placeholder' => $model->getAttributeLabel('zip')])->label(false) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'country', [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-md-12',
                            'offset' => '',
                        ]
                    ])->textInput(['placeholder' => $model->getAttributeLabel('country')])
                        ->dropDownList(['US' => 'United States'])
                        ->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?= $form->field($user, 'email', ['enableAjaxValidation' => true])->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
            <?= $form->field($user, 'password_field')->passwordInput(['placeholder' =>  'Password']) ?>
            <?= $form->field($user, 'password_repeat')->passwordInput(['placeholder' =>  'Verify Password']) ?>
            <?= $form->field($model, 'phone_number')->textInput(['placeholder' => $model->getAttributeLabel('phone_number')]) ?>
            <?= $form->field($model, 'location_type')->dropDownList(\app\models\Profile::locationType(), ['placeholder' => $model->getAttributeLabel('location_type')]) ?>
        </div>
        <div class="col-md-12 text-center">
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary bnt-member']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="row">
        <h1 class="text-center">GRID-TIE ESTIMATOR</h1>
        <div class="col-md-6">
            <h3>Step 1</h3>
            <p>Determine your monthly kWh usage from your utility bill.</p>
            <div class="form-group">
                <a class="fancy_image" href="/images/site/pnmbill.jpg">
                    <button class="btn btn-success"><i class="fa fa-newspaper-o" aria-hidden="true"></i> See a sample bill</button>
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Step 2</h3>
            <p>Find the Sun Hours available in your area.</p>
            <div class="form-group">
                <a class="fancy_image" href="/images/site/solar_radia_map.gif">
                    <button class="btn btn-success"><i class="fa fa-newspaper-o" aria-hidden="true"></i> See the Sun Hours Map</button>
                </a>
            </div>
        </div>
        <div class="col-md-12">
            <h3>Step 3</h3>
            <h4>Enter your information in the fields below.</h4>
        </div>
        <div class="col-md-6">
            <h4>Average monthly usage in kWh</h4>
            <?= Html::input('text', 'field_akwh', null, ['class' => 'form-control', 'id' => 'field_akwh', 'placeholder' => "500 kWh"]) ?>
        </div>
        <div class="col-md-6">
            <h4>What % of your energy would you like to offset?</h4>
            <?= Html::input('text', 'field_percent', null, ['class' => 'form-control', 'id' => 'field_percent', 'placeholder' => "90%"]) ?>
        </div>
        <div class="col-md-6">
            <h4>Average monthly bill in $</h4>
            <?= Html::input('text', 'field_bill', null, ['class' => 'form-control', 'id' => 'field_bill', 'placeholder' => "210$"]) ?>
        </div>
        <div class="col-md-6">
            <h4>Average peak Sun Hours for your location</h4>
            <?= Html::input('text', 'field_sunhrs', null, ['class' => 'form-control', 'id' => 'field_sunhrs', 'placeholder' => "5.5"]) ?>
        </div>
        <div class="col-md-12">
            <br>
            <div class="form-group">
                <button class="btn btn-warning estimator_check">CALCULATE</button>
            </div>
        </div>
        <div class="result">
            <div id="wattage"></div>
            <div id="financial"></div>
            <div id="utilize"></div>
            <div id="housevalue"></div>
            <div id="savings1"></div>
            <div id="savings15"></div>
            <div id="savings20"></div>
            <div id="environmental"></div>
            <div id="trees"></div>
        </div>
    </div>
</div><!-- user-member-sign-up -->

