<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class DatetimepickerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'datetimepicker/jquery.datetimepicker.css',
    ];
    public $js = [
        'datetimepicker/build/jquery.datetimepicker.full.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}