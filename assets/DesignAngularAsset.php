<?php

namespace app\assets;

use yii\web\AssetBundle;


class DesignAngularAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/ng/angular.min.js',
        'js/ng/angular-ui-router.min.js',
        'js/ng/angular-material.min.js',
        'js/ng/angular-animate.min.js',
        'js/ng/angular-aria.min.js',
        'js/ng/lodash.min.js',
//        '//cdn.jsdelivr.net/lodash/3.10.1/lodash.min.js',
        'js/ng/angular-simple-logger.min.js',
        'js/ng/angular-google-maps.js'
    ];
    public $css = [

    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}