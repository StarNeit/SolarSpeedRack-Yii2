<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Awsaf <awsaf.anam@gmail.com>
 * @since 1.0
 */
class NewDesignAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/ng/angular-material.min.css',
        'css/roboto.css',
        'css/rzslider.min.css',
        'css/rateit/rateit.css',
        'css/newapp.css',
        ['css/print.css', 'media' => 'print']
    ];
    public $js = [
        'js/ng/pagination.js',
        'js/ng/angular-material.js',
        'js/ng/angular-sanitize.min.js',
        'js/ng/mask.min.js',
        'js/ng/rzslider.min.js',
        'appnew/app.js',
        'appnew/services/config.js',
        'appnew/services/calculator.js',
        'appnew/services/speedrack.js',
        'appnew/services/shared.js',
        'appnew/services/standard.js',
        'appnew/services/layout.js',
        'appnew/services/project.js',
        'appnew/controllers/controllers.js',
        'appnew/directives/directives.js',
        'appnew/routes.js'
    ];
    public $depends = [
        'sersid\fontawesome\Asset',
        'app\assets\DesignAngularAsset',
        'app\assets\D3Asset',
        'app\assets\AppAsset',
    ];
}