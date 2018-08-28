<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Awsaf <awsaf.anam@gmail.com>
 * @since 1.0
 */
class D3Asset extends AssetBundle
{

    /**
     * @inherit
     */
    public $sourcePath = '@vendor/mbostock/d3';

    /**
     * @inherit
     */
    public $js = [
        'd3.min.js',
    ];

    /**
     * Initializes the bundle.
     * Set publish options to copy only necessary files (in this case css and font folders)
     */
    public function init()
    {
        parent::init();

        $this->publishOptions['beforeCopy'] = function ($from, $to) {
            return preg_match('%[\\\/](d3.js|d3.min.js)%', $from);
        };
    }
}