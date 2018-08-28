<?php
/**
 */

namespace app\widgets;

use Yii;
/**
 * @author Awsaf Anam Chowdhury<awsaf.anam.com>
 */
class AdminTopMenu extends \yii\base\Widget
{
    /**
     * @var array of menu items
     */
    public $items = [];


    public function init()
    {
        parent::init();

    }

    public function run()
    {
        return $this->render('adminTopMenu', [
            'items'=> $this->items
        ]);
    }
}