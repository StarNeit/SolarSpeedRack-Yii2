<?php
/**
 * Created by PhpStorm.
 * User: Asad
 * Date: 1/23/2017
 * Time: 6:11 PM
 */
//          if (Yii::$app->user->can('installer'))
//          if (Yii::$app->user->can('member'))
//          if (Yii::$app->user->can('admin'))
//           if (Yii::$app->user->can('all'))
?>
<div class="intro">
    <div class="container">

        <div class="control-panel__row control__panel-mob">
            <a href="#slider1_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-user.png" alt="User">
                </div>
                <p class="control-panel__cube-text">User</p>
            </a>


            <?php if (Yii::$app->user->can('installer') || Yii::$app->user->can('admin') || Yii::$app->user->can('all')): ?>

                <a href="#slider2_container" class="control-panel__cube control-panel__images">
                    <div class="control-panel__cube-img-holder">
                        <img src="img/c-panel-reports.png" alt="Reports">
                    </div>
                    <p class="control-panel__cube-text">Reports</p>
                </a>

            <?php endif; ?>


            <a href="#slider3_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-products.png" alt="Products">
                </div>
                <p class="control-panel__cube-text">Products</p>
            </a>

            <?php if (Yii::$app->user->can('member') || Yii::$app->user->can('admin') || Yii::$app->user->can('all')): ?>

                <a href="#slider4_container" class="control-panel__cube control-panel__images">
                    <div class="control-panel__cube-img-holder">
                        <img src="img/c-panel-service-mode.png" alt="Service mode">
                    </div>
                    <p class="control-panel__cube-text">Service Mode</p>
                </a>

            <?php endif; ?>


            <a href="#slider5_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-datebase.png" alt="Database">
                </div>
                <p class="control-panel__cube-text">Database</p>
            </a>
            
            
            <a href="#slider6_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-chat-history.png" alt="Chat History">
                </div>
                <p class="control-panel__cube-text">Chat History</p>
            </a>
            
            
            <a href="#slider7_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-newsletter.png" alt="Newsletter">
                </div>
                <p class="control-panel__cube-text">Newsletter</p>
            </a>
            
            
            <a href="#slider8_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-financing.png" alt="Financing">
                </div>
                <p class="control-panel__cube-text">Financing</p>
            </a>
            
             <?php if (Yii::$app->user->can('member') || Yii::$app->user->can('admin') || Yii::$app->user->can('all')): ?>

            <a href="#slider9_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-installers.png" alt="Installers">
                </div>
                <p class="control-panel__cube-text">Installers</p>
            </a>
            
            <?php endif; ?>
            
            
            <a href="#slider10_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-vendors.png" alt="Vendors">
                </div>
                <p class="control-panel__cube-text">Vendors</p>
            </a>
            
            
            <a href="#slider11_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-orders.png" alt="Orders">
                </div>
                <p class="control-panel__cube-text">Orders</p>
            </a>
            
            
            <a href="#slider12_container" class="control-panel__cube control-panel__images">
                <div class="control-panel__cube-img-holder">
                    <img src="img/c-panel-alerts.png" alt="Alerts">
                </div>
                <p class="control-panel__cube-text">Alerts</p>
            </a>
            
            
        </div>

        <a href="#slider1_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-user.png" alt="User">
            </div>
            <p class="control-panel__cube-text">User</p>
        </a>
        <div class="panel__hidden active" id="slider1_container">
            <h2 class="heading-two heading-two_margin-b">User Profile</h2>
            <div class="registration">
                <div class="registration__holder">
                    <form>
                        <div class="registration__items">
                            <span class="registration__label">
                                Full Name
                            </span>
                            <div class="registration__input-holders registration__input-holders_half">
                                <input type="text" class="registration__input" placeholder="First Name">
                                <input type="text" class="registration__input" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Address
                            </span>
                            <div class="registration__input-holders">
                                <input type="text" class="registration__input registration__input_full-width" placeholder="Street Address">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label registration__label_align">

                            </span>
                            <div class="registration__input-holders">

                                <input type="text" class="registration__input registration__input_full-width" placeholder="Street Address Line2">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label registration__label_align">

                            </span>
                            <div class="registration__input-holders registration__input-holders_half">
                                <input type="text" class="registration__input" placeholder="city">
                                <div class="registration__select-holder">
                                    <select class="registration__input registration__select">
                                        <option>State/Province</option>
                                        <option>State/Province</option>
                                        <option>State/Province</option>
                                        <option>State/Province</option>
                                        <option>State/Province</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label registration__label_align">

                            </span>
                            <div class="registration__input-holders registration__input-holders_half">
                                <input type="text" class="registration__input" placeholder="Postal/ZIP Code">
                                <div class="registration__select-holder">
                                    <select class="registration__input registration__select">
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="registration__holder panel__hidden">
                    <form>
                        <div class="registration__items">
                            <span class="registration__label">
                                Email
                            </span>
                            <div class="registration__input-holders">
                                <input type="email" class="registration__input registration__input_full-width" placeholder="Street Address">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Password
                            </span>
                            <div class="registration__input-holders">
                                <input type="password" class="registration__input registration__input_full-width" placeholder="********">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Verify Password
                            </span>
                            <div class="registration__input-holders">
                                <input type="password" class="registration__input registration__input_full-width" placeholder="********">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Contact Number
                            </span>
                            <div class="registration__input-holders">
                                <input type="text" class="registration__input registration__input_full-width" placeholder="Area Code - Phone Number">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Location Type
                            </span>
                            <div class="registration__input-holders">
                                <div class="registration__select-holder registration__select-holder_full-width">
                                    <select class="registration__input registration__select">
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="registration__holder">
                    <form>
                        <div class="registration__items">
                            <span class="registration__label">
                                Email
                            </span>
                            <div class="registration__input-holders">
                                <input type="email" class="registration__input registration__input_full-width" placeholder="Street Address">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Password
                            </span>
                            <div class="registration__input-holders">
                                <input type="password" class="registration__input registration__input_full-width" placeholder="********">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Verify Password
                            </span>
                            <div class="registration__input-holders">
                                <input type="password" class="registration__input registration__input_full-width" placeholder="********">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Contact Number
                            </span>
                            <div class="registration__input-holders">
                                <input type="text" class="registration__input registration__input_full-width" placeholder="Area Code - Phone Number">
                            </div>
                        </div>
                        <div class="registration__items">
                            <span class="registration__label">
                                Location Type
                            </span>
                            <div class="registration__input-holders">
                                <div class="registration__select-holder registration__select-holder_full-width">
                                    <select class="registration__input registration__select">
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                        <option>United States</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <a href="#slider2_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-reports.png" alt="Reports">
            </div>
            <p class="control-panel__cube-text">Reports</p>
        </a>
        <div class="panel__hidden" id="slider2_container">
            Reports Content here
        </div>

        <a href="#slider3_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-products.png" alt="Products">
            </div>
            <p class="control-panel__cube-text">Products</p>
        </a>
        <div class="panel__hidden" id="slider3_container" style="display: block;">
            <div class="product-layout">
                <div class="box-holder box">
                    <div class="product-image"><img src="img/products/modules.png" alt="Modules"></div>
                    <div class="product-title">MODULES</div>
                    <div class="product-info"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><span>Product Info</span></div>
                    <div class="product-installation"><i class="glyphicon glyphicon-wrench" aria-hidden="true"></i><span>Installation Manual</span></div>
                    <div class="product-warranty"><i class="glyphicon glyphicon-certificate" aria-hidden="true"></i><span>Product Warranty</span></div>
                    <div class="product-contact"><i class="glyphicon glyphicon-earphone earphone" aria-hidden="true"></i><span class="texter">Manufacturer <span class="box-holder-contact">Contact</span></span>
                    </div>
                </div>
                <div class="box-holder box">
                    <div class="product-image"><img src="img/products/microInverter.png" alt="Microinventer"></div>
                    <div class="product-title">MICRO-INVERTER</div>
                    <div class="product-info"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><span>Product Info</span></div>
                    <div class="product-installation"><i class="glyphicon glyphicon-wrench" aria-hidden="true"></i><span>Installation Manual</span></div>
                    <div class="product-warranty"><i class="glyphicon glyphicon-certificate" aria-hidden="true"></i><span>Product Warranty</span></div>
                    <div class="product-contact"><i class="glyphicon glyphicon-earphone earphone" aria-hidden="true"></i><span class="texter">Manufacturer <span class="box-holder-contact">Contact</span></span>
                    </div>
                </div>
                <div class="box-holder box">
                    <div class="product-image"><img src="img/products/inverter.png" alt="Inventer"></div>
                    <div class="product-title">INVERTER</div>
                    <div class="product-info"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><span>Product Info</span></div>
                    <div class="product-installation"><i class="glyphicon glyphicon-wrench" aria-hidden="true"></i><span>Installation Manual</span></div>
                    <div class="product-warranty"><i class="glyphicon glyphicon-certificate" aria-hidden="true"></i><span>Product Warranty</span></div>
                    <div class="product-contact"><i class="glyphicon glyphicon-earphone earphone" aria-hidden="true"></i><span class="texter">Manufacturer <span class="box-holder-contact">Contact</span></span>
                    </div>
                </div>
                <div class="box-holder box">
                    <div class="product-image"><img src="img/products/monitoring.png" alt="Monitoring"></div>
                    <div class="product-title">MONITORING</div>
                    <div class="product-info"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><span>Product Info</span></div>
                    <div class="product-installation"><i class="glyphicon glyphicon-wrench" aria-hidden="true"></i><span>Installation Manual</span></div>
                    <div class="product-warranty"><i class="glyphicon glyphicon-certificate" aria-hidden="true"></i><span>Product Warranty</span></div>
                    <div class="product-contact"><i class="glyphicon glyphicon-earphone earphone" aria-hidden="true"></i><span class="texter">Manufacturer <span class="box-holder-contact">Contact</span></span>
                    </div>
                </div>
                <div class="box-holder box">
                    <div class="product-image"><img src="img/products/racking.png" alt="Racking"></div>
                    <div class="product-title">RACKING</div>
                    <div class="product-info"><i class="glyphicon glyphicon-info-sign" aria-hidden="true"></i><span>Product Info</span></div>
                    <div class="product-installation"><i class="glyphicon glyphicon-wrench" aria-hidden="true"></i><span>Installation Manual</span></div>
                    <div class="product-warranty"><i class="glyphicon glyphicon-certificate" aria-hidden="true"></i><span>Product Warranty</span></div>
                    <div class="product-contact"><i class="glyphicon glyphicon-earphone earphone" aria-hidden="true"></i><span class="texter">Manufacturer <span class="box-holder-contact">Contact</span></span>
                    </div>
                </div>
            </div>
        </div>

        <a href="#slider4_container" class="control-panel__cube control-panel__images  mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-service-mode.png" alt="Service mode">
            </div>
            <p class="control-panel__cube-text">Service Mode</p>
        </a>
        <div class="fields panel__hidden" id="slider4_container">
            <div class="fields__layout">
                <div class="fields__left-holder">
                    <p class="fields__title">SYSTEM PERFORMANCE</p>
                    <div class="fields__box-value">
                        <a href="#" class="fields__percent">
                            <i class="fa fa-caret-up fields__box-arrow" aria-hidden="true"></i>
                            <span>43%</span>
                        </a>
                        <span class="fields__box-kw">6.8kW</span>
                    </div>
                </div>
                <div class="fields__right-holder">
                    <div class="fields__row">
                        <div class="fields__col">
                            <div class="fields__cube">
                                <p class="fields__title">QUICK CHANGES</p>
                                <div class="fields__buttons-holder">
                                    <a href="#" class="fields__buttons">WiFi Key Change</a>
                                    <a href="#" class="fields__buttons">WiFi Key Change</a>
                                </div>
                            </div>
                        </div>
                        <div class="fields__col">
                            <div class="fields__rectangle">
                                <p class="fields__title">REMINDERS &AMP; ALERTS</p>
                                <div class="fields__rectangle-align-holder">
                                    <i class="fa fa-bell fa-2x fields__rectangle-icon" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="fields__rectangle fields__rectangle_img">
                                <img src="img/fields-app.png" class="fields__rectangle-image" alt="App store">
                            </div>
                        </div>
                        <div class="fields__col">
                            <div class="fields__rectangle">
                                <p class="fields__title">SUPPORT</p>
                                <p class="fields__title">Cost of System</p>
                                <div class="fields__rectangle-align-holder">
                                    <i class="fa fa-users fa-2x fields__rectangle-icon" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="fields__rectangle fields__rectangle-align-holder-two">
                                <p class="fields__title">SCHEDULED MAINTENANCE</p>
                                <div>
                                    <div class="fields__rectangle-spaced">
                                        <p class="fields__small-text">Now 28 Away</p>
                                        <i class="fa fa-home fa-lg fields__rectangle-icon" aria-hidden="true"></i>
                                    </div>
                                    <div class="fields__rectangle-date">
                                        <span class="fields__rectangle-circle-edge"></span>
                                        <span class="fields__rectangle-line"></span>
                                        <span class="fields__rectangle-circle-edge"></span>
                                    </div>
                                    <p class="fields__small-text fields__small-text_right">4:00 pm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fields__row">
                        <div class="fields__col">
                            <div class="fields__rectangle">
                                <p class="fields__title">SETTINGS</p>
                                <div class="fields__rectangle-align-holder">
                                    <i class="fa fa-cog fa-2x fields__rectangle-icon fields__rectangle-icon_green" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="fields__rectangle">
                                <p class="fields__title fields__title_red ">SYSTEM OFF</p>
                            </div>

                        </div>
                        <div class="fields__col">
                            <div class="fields__cube">
                                <div>
                                    <p class="fields__title">WEATHER</p>
                                    <p class="fields__title">Santa Ana</p>
                                </div>
                                <div>
                                    <i class="fa fa-cloud fa-4x fields__cloud-icon" aria-hidden="true"></i>
                                    <span class="fields__cloud">60</span>
                                </div>
                                <p class="fields__title">
                                    Mostly Cloudy
                                </p>

                            </div>
                        </div>
                        <div class="fields__col">
                            <div class="fields__rectangle fields__rectangle_align">
                                <p class="fields__title">WIFI</p>
                                <div class="fields__rectangle-spaced fields__rectangle-spaced_align-bottom">
                                    <div>
                                        <div class="fields__rectangle-switch-holder">
                                            <a href="#" class="fields__rectangle-switch fields__rectangle-switch_active">Auto</a>
                                            <a href="#" class="fields__rectangle-switch">On</a>
                                        </div>
                                    </div>
                                    <i class="fa fa-wifi fa-2x fields__rectangle-icon" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="fields__rectangle">
                                <p class="fields__title">TOTAL POWER</p>
                                <p class="fields__title"><strong>28254KW</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="#slider5_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-datebase.png" alt="Database">
            </div>
            <p class="control-panel__cube-text">Database</p>
        </a>
        <div class="panel__hidden" id="slider5_container">
            Database Content here
        </div>

        <a href="#slider6_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-chat-history.png" alt="Chat History">
            </div>
            <p class="control-panel__cube-text">Chat History</p>
        </a>
        <div class="panel__hidden" id="slider6_container">
            Chat History Content here
        </div>

        <a href="#slider7_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-newsletter.png" alt="Newsletter">
            </div>
            <p class="control-panel__cube-text">Newsletter</p>
        </a>
        <div class="panel__hidden" id="slider7_container">
            Newsletter Content here
        </div>

        <a href="#slider8_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-financing.png" alt="Financing">
            </div>
            <p class="control-panel__cube-text">Financing</p>
        </a>
        <div class="panel__hidden" id="slider8_container">
            Financing Content here
        </div>

        <a href="#slider9_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-installers.png" alt="Installers">
            </div>
            <p class="control-panel__cube-text">Installers</p>
        </a>
        <div class="panel__hidden" id="slider9_container">
            Installers Content here
        </div>

        <a href="#slider10_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-vendors.png" alt="Vendors">
            </div>
            <p class="control-panel__cube-text">Vendors</p>
        </a>
        <div class="panel__hidden" id="slider10_container">
            Vendors Content here
        </div>

        <a href="#slider11_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-orders.png" alt="Orders">
            </div>
            <p class="control-panel__cube-text">Orders</p>
        </a>
        <div class="panel__hidden" id="slider11_container">
            Orders Content here
        </div>

        <a href="#slider12_container" class="control-panel__cube control-panel__images mobile-cube">
            <div class="control-panel__cube-img-holder">
                <img src="img/c-panel-alerts.png" alt="Alerts">
            </div>
            <p class="control-panel__cube-text">Alerts</p>
        </a>
        <div class="panel__hidden" id="slider12_container">
            Alerts Content here dfsdfs
        </div>

    </div>
</div>
