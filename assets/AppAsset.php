<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.jsdelivr.net/g/jquery.roundslider@1.3(roundslider.min.css)',
        'css/style.css',
        'css/custom.css',
        
        'css/s2_modal.css',
        'css/s4_modal.css',
        'css/slider.css',
        'css/circle.css',
        'css/style_new.css',
        'css/round_slider.css'
    ];
    public $js = [
        "/js/main.js"
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'sersid\fontawesome\Asset',
        'yii\web\YiiAsset',
    ];
}
