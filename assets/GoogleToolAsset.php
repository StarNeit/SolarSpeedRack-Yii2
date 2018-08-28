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
class GoogleToolAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $css = [
        'css/map.css',
    ];
    public $js = [
        'js/map/aac.js',
        // 'js/map/map.js',
        'js/map/utils/config.js',
        'js/map/utils/functions.js',
        'js/map/utils/map-options.js',
        'js/map/utils/shapes.js',
        'js/map/utils/overlays.js',
        'js/map/utils/panels.js',
        'js/map/utils/layout.js',
        'js/map/utils/calculator.js',
        'js/map/utils/shared.js',
        'js/map/listeners.js',
        'js/map/listeners.js',
        'js/toastr.min.js',

//        'js/map/custom_shapes.js',
//        'js/map/List.js',
//        'js/map/maphandler.js',
//        'js/map/maphandler.maps.overlays.js',
//        'js/map/listeners.js',
//        'js/map/gmap.js',
//        'js/map/map-options.js'
//        'js/map/main.js',
    ];
    public $depends = [
        'sersid\fontawesome\Asset',
        'app\assets\AppAsset',
    ];
}