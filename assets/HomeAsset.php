<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class HomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/home.css',
    ];
    public $js = [
        "https://maps.googleapis.com/maps/api/js?key=AIzaSyC15OkDyDw78Zt8T-PfZHdEpjodipGG8FY&libraries=drawing,places",
        'https://www.google.com/recaptcha/api.js',
        'js/bootstrap.min.js',
        "js/bootstrap-slider.js",
        "js/roundslider.min.js",
        "js/jquery.waitforimages.min.js",
        "js/scrolloverflow.min.js",
        "js/jquery.fullPage.min.js",
        "js/jquery.stellar.min.js",
        "js/tabcontent.js",
        'js/homepage.js',

        'https://cdn.jsdelivr.net/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js',
        "js/jquery-circle-progress.js",
        'js/slider.js',
        'js/circle.js',
        'js/s4_modal.js',
        'js/round_slider.js',
        'js/modal.js',
        'js/googlemap.js',
        'js/utils.js',
        'js/s2_modal.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}