<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\rating\StarRating;

$this->title = 'System and Financing Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-finance">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row finance-tbl">
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="inner block1">
                        <div class="title">System size</div>
                        <div class="descr">1.8 kwt</div>
                        <div class="name">Locations</div>
                        <div class="descr">San Diego, Californiya</div>
                        <div class="number">1</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner block2">
                        <div class="title">Solar Panels</div>
                        <div class="image logos"><?= Html::img('/images/logos/1_m.jpg') ?></div>
                        <div class="company">SolarWorld</div>
                        <div class="name">Model</div>
                        <div class="descr">SW265 Mono BlackF</div>
                        <div class="name">Panel</div>
                        <div class="stars"><?php
                            echo StarRating::widget([
                                'name' => 'rating_1',
                                'value' => 4,
                                'pluginOptions' => [
                                    'showClear'=>false,
                                    'showCaption' => false,
                                    'size'=> 'xs',
                                    'displayOnly' => true
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="stars-desc"><strong>4.79</strong> based on <span>34 reviews</span></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner block3">
                        <div class="title">Inverters</div>
                        <div class="image logos"><?= Html::img('/images/logos/1_m.jpg') ?></div>
                        <div class="company">Solar World</div>
                        <div class="name">Model</div>
                        <div class="descr">SE Mono BlackF</div>
                        <div class="name">Panel</div>
                        <div class="stars"><?php
                            echo StarRating::widget([
                                'name' => 'rating_2',
                                'value' => 5,
                                'pluginOptions' => [
                                    'showClear'=>false,
                                    'showCaption' => false,
                                    'size'=> 'xs',
                                    'displayOnly' => true
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="stars-desc"><strong>4.79</strong> based on <span>34 reviews</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-4">
                    <div class="inner block4">
                        <div class="total-block text-center">
                            <div class="title">Total System Cost</div>
                            <div class="costs">$18000</div>
                            <div class="descr2">(before 30% solar tax credit)</div>
                        </div>
                        <div class="descr-block">
                            <div class="descr1">Levilezed cost of Solar Power (c/Kwh) <i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            <div class="descr1">Av.cost - utility power over 25 years (c/Kwh) <i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            <div class="descr1">Profit after repayments(100% loan) <i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            <div class="descr1">Profit (Cash purchase) <i class="fa fa-info-circle" aria-hidden="true"></i></div>
                        </div>
                        <button class="btn btn-green">VIEW DETAILS</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner block5">
                        <div class="total-block text-center">
                            <div class="title">Cost of System</div>
                            <div class="costs">$ 2.96 per watt</div>
                            <div class="descr2">(Before 30% solar tax credit)</div>
                        </div>
                        <div class="descr-block">
                            <div class="descr1">5.52</div>
                            <div class="descr3 text-center">Your Monthly Payment</div>
                            <div class="descr1">36.02</div>
                            <div class="descr3 text-center">$242.32/mo</div>
                            <div class="descr1">$19,021</div>
                            <div class="descr1">$21,269</div>
                        </div>
                        <button class="btn btn-orange">Click here to apply for financing</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="inner block6">
                        <div class="total-block">
                            <div class="title text-center">Additional options</div>
                            <div class="descr">(before 30% solar tax credit)</div>
                        </div>
                        <div class="descr1">Levilezed cost of solar power</div>
                        <div class="descr1">Levilezed cost of solar power</div>
                        <div class="descr1">Levilezed cost of solar power</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
