<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dektrium\user\widgets\Connect;

/**
 * @var yii\web\View                   $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module           $module
 */

$this->title = 'Don\'t have an account sign up for free to the NSSC Group Store';
$this->params['breadcrumbs'][] = Yii::t('user', 'Sign in');

$this->registerMetaTag(['name'=>'description', 'content'=> 'Sign up today for free access to the online store, planning tools and project management system.']);
$this->registerMetaTag(['name'=>'keywords', 'content'=>'solar account, solar log in']);

$this->registerJs('$(".tgl").click(function(){
    $(".login-form").toggleClass("to-right");
    $(".lform").slideToggle();
    $(".llink").slideToggle();
});')

?>


<div class="row secr-login-page">

    <div class="col-md-8 col-md-offset-2 login">
        <div class="signup-text">
            <h1>Don't Have an Account?</h1>
            <p>
                <?= Html::a('SIGN UP', '#', ['class' => 'btn btn-transparent tgl']) ?>
            </p>
        </div>
        <div class="login-text">
            <h1>Have an Account?</h1>
            <p class="text-right">
                <?= Html::a('SIGN IN', '#', ['class' => 'btn btn-transparent tgl']) ?>
            </p>
        </div>
        <div class="login-form to-right">
            <button type="button" class="close"><a href="/"><span aria-hidden="true">×</span></a></button>
            <div class="lform">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>
                <h1>
                    LOG IN
                </h1>

                <?= $form->field($model, 'login', ['inputOptions' => ['placeholder'=>'Username / Email', 'autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1'], 'options'=> ['class'=>'form-group no-label']])->label('') ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['placeholder'=>'Password', 'class' => 'form-control', 'tabindex' => '2'], 'options'=> ['class'=>'form-group no-label']])->passwordInput()->label('') ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4'])->label('') ?>

                <div class="row">
                    <div class="col-xs-6 fgt">
                        <?= Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']) ?>
                    </div>
                    <div class="col-xs-6">
                        <?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-primary btn-block', 'tabindex' => '3']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="llink" style="display: none;">
                <h1>SIGN UP AS</h1>
                <p>&nbsp;</p>
                <div class="text-center">
                    <p>
                        <?= Html::a('MEMBER', ['/user/registration/member-sign-up'], ['class' => 'btn btn-primary']) ?>
                    </p>
                    <p class="">OR</p>

                    <p>
                        <?= Html::a('SUPPLIER', ['/user/registration/supplier-sign-up'], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
                <p>&nbsp;</p>
            </div>
        </div>

        <?php /* if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
            </p>
        <?php endif ?>
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                Don\'t have an account?
            </p>
            <p class="text-center">
                <?= Html::a('Sign up as Member!', ['/user/registration/member-sign-up']) ?>
            </p>
            <p class="text-center">
                Or
            </p>
            <p class="text-center">
                <?= Html::a(' Sign up as Supplier!', ['/user/registration/supplier-sign-up']) ?>
            </p>
        <?php endif ?>
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth']
        ])*/ ?>
    </div>
</div>
