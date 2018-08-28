<?php
/**
 */

namespace app\widgets;

use Yii;
/**
 * @author Awsaf Anam Chowdhury<awsaf.anam.com>
 */
class AdminSideMenu extends \yii\base\Widget
{
    /**
     * @var array of menu items
     */
    public $items = [];


    public function init()
    {
        parent::init();
        $cid = Yii::$app->controller->id;

        $this->items = [
//                [
//                    'label' => 'Frontend',
//                    'url' => ['/'],
//                    'active' => false
//                ],
            [
                'label' => 'Dashboard',
                'url' => ['/manage'],
                'active' => $cid == 'default'
            ],
            [
                'label' => 'Store',
                'url' => ['/store.html'],
                'active' => $cid == 'store'
            ],
            [
                'label' => 'Advertisements',
                'url' => ['/manage/advertise/index'],
                'active' => Yii::$app->controller->module->id == 'manage' &&
                    $cid == 'advertise'
            ],
            [
                'label' => 'Emails',
                'url' => '#',
                'active' => $cid == 'email-campaign' || $cid == 'email-template' || $cid == 'email-config',
                'items'=> [
                    [
                        'label' => 'Campaigns',
                        'url' => ['/manage/email-campaign/index'],
                        'active' => $cid == 'email-campaign'
                    ],
                    [
                        'label' => 'Templates',
                        'url' => ['/manage/email-template/index'],
                        'active' => $cid == 'email-template'
                    ],
                    [
                        'label' => 'Config',
                        'url' => ['/manage/email-config/index'],
                        'active' => $cid == 'email-config'
                    ],
                ]
            ],
            [
                'label' => 'Homepage',
                'url' => '#',
                'active' => $cid == 'supplier-logo' || $cid == 'slider' || $cid == 'homepage-items' || ($cid == 'default' && Yii::$app->controller->action->id == 'home-notice'),
                'items'=> [
                    [
                        'label' => 'Notice',
                        'url' => ['/manage/default/home-notice'],
                        'active' => $cid == 'default' && Yii::$app->controller->action->id == 'home-notice'
                    ],
                    [
                        'label' => 'Slider',
                        'url' => ['/manage/slider'],
                        'active' => $cid == 'slider'
                    ],
                    [
                        'label' => 'Logos',
                        'url' => ['/manage/supplier-logo'],
                        'active' => $cid == 'supplier-logo'
                    ],
                    [
                        'label' => 'Boxes',
                        'url' => ['/manage/homepage-items'],
                        'active' => $cid == 'homepage-items'
                    ],
                ]
            ],
            [
                'label' => 'Members',
                'url' => ['/manage/member/index'],
                'active' => $cid == 'member' || $cid == 'company' || $cid == 'package' || $cid == 'credit' || $cid == 'cash-transaction',
                'items'=> [
                    [
                        'label' => 'All Members',
                        'url' => ['/manage/member/index'],
                        'active' => $cid == 'member'
                    ],
                    [
                        'label' => 'Companies',
                        'url' => ['/manage/company/index'],
                        'active' => $cid == 'company'  && Yii::$app->controller->action->id == 'index'
                    ],
                    [
                        'label' => 'Resellers',
                        'url' => ['/manage/company/resellers'],
                        'active' => $cid == 'company' && Yii::$app->controller->action->id == 'resellers'
                    ],
                    [
                        'label' => 'Packages',
                        'url' => ['/manage/package/index'],
                        'active' => $cid == 'package'
                    ],
                    [
                        'label' => 'Credit Applications',
                        'url' => ['/manage/credit/index'],
                        'active' => $cid == 'credit'
                    ],
                    [
                        'label' => 'Cash Transaction',
                        'url' => ['/manage/cash-transaction/index'],
                        'active' => $cid == 'cash-transaction'
                    ],
                    [
                        'label' => 'View Member Dashboard',
                        'url' => ['/manage/member/transform'],
                        'active' => $cid == 'member' && Yii::$app->controller->action->id == 'transform'
                    ],
                ]
            ],
            [
                'label' => 'Orders',
                'url' => '#',
                'active' => $cid == 'order' || $cid == 'project' || $cid == 'purchase-order' || $cid == 'permit-package',
                'items'=> [
                    [
                        'label' => 'All Orders',
                        'url' => ['/manage/order/index'],
                        'active' => $cid == 'order'
                    ],
                    [
                        'label' => 'Projects',
                        'url' => ['/manage/project/index'],
                        'active' => $cid == 'project'
                    ],
                    [
                        'label' => 'Purchase Order',
                        'url' => ['/manage/purchase-order/index'],
                        'active' => $cid == 'purchase-order'
                    ],
                    [
                        'label' => 'Permit Packages',
                        'url' => ['/manage/permit-package/index'],
                        'active' => $cid == 'permit-package'
                    ],
                ]
            ],
            [
                'label' => 'Products',
                'url' => '#',
                'active' => $cid == 'product' || $cid == 'pcategory' || $cid == 'coupon' || $cid == 'handling' || $cid == 'manufacturer' || $cid == 'product-package' ,
                'items'=> [
                    [
                        'label' => 'All Products',
                        'url' => ['/manage/product/index'],
                        'active' => $cid == 'product'
                    ],
                    [
                        'label' => 'Product Packages',
                        'url' => ['/manage/product-package/index'],
                        'active' => $cid == 'product-package'
                    ],
                    [
                        'label' => 'Coupons',
                        'url' => ['/manage/coupon/index'],
                        'active' => $cid == 'coupon'
                    ],
                    [
                        'label' => 'Product Category',
                        'url' => ['/manage/pcategory/index'],
                        'active' => $cid == 'pcategory'
                    ],
                    [
                        'label' => 'Handling Configs',
                        'url' => ['/manage/handling/index'],
                        'active' => $cid == 'handling'
                    ],
                    [
                        'label' => 'Manufacturers',
                        'url' => ['/manage/manufacturer/index'],
                        'active' => $cid == 'manufacturer'
                    ],
                    [
                        'label' => 'Change Price Percent Globally',
                        'url' => ['/manage/default/change-rate'],
                        'active' => $cid == 'default' && Yii::$app->controller->action->id == 'change-rate'
                    ],
                ]
            ],
            [
                'label' => 'Suppliers',
                'url' => ['/manage/supplier'],
                'active' => $cid == 'supplier',
                'items'=> [
//                    [
//                        'label' => 'All Suppliers',
//                        'url' => ['/manage/supplier'],
//                        'active' => $cid == 'supplier'
//                    ],
                    [
                        'label' => 'Supplier Companies',
                        'url' => ['/manage/supplier-company/index'],
                        'active' => $cid == 'supplier-company'
                    ],
                ]
            ],
            [
                'label' => 'Settings',
                'url' => ['/manage/setting/index'],
                'active' => $cid == 'setting'
            ],
            [
                'label' => 'Pages',
                'url' => ['/manage/page/index'],
                'active' => $cid == 'page'
            ],
            [
                'label' => 'Parts',
                'url' => '#',
                'active' => $cid == 'zipcode' || $cid == 'accessory' || $cid == 'cell-tech',
                'items'=> [
                    [
                        'label' => 'Metadatas',
                        'url' => ['/manage/zipcode/index'],
                        'active' => $cid == 'zipcode'
                    ],
                    [
                        'label' => 'Accessories',
                        'url' => ['/manage/accessory/index'],
                        'active' => $cid == 'accessory'
                    ],
                    [
                        'label' => 'Cell Technologies',
                        'url' => ['/manage/cell-tech/index'],
                        'active' => $cid == 'cell-tech'
                    ],
                ]
            ],
            [
                'label' => 'Users',
                'url' => '#',
                'active' => Yii::$app->controller->module->id == 'user' || Yii::$app->controller->module->id == 'admin',
                'items'=> [
                    [
                        'label' => 'Manage Users',
                        'url' => ['/user/admin/index'],
                        'active' => Yii::$app->controller->module->id == 'user',
                    ],
                    [
                        'label' => 'User Assignments',
                        'url' => ['/admin/permission'],
                        'active' => Yii::$app->controller->module->id == 'admin',
                        'visible' => Yii::$app->user->can('all')
                    ],
                ]
            ],
            [
                'label' => 'Log Out',
                'url' => ['/site/logout'],
                'active' => FALSE
            ],
//                [
//                    'label' => 'Emails',
//                    'url' => '#',
//                    'active' => $cid == 'setting' || $cid == 'setting' || $cid == 'setting',
//                    'items'=> [
//                    ]
//                ],
        ];
    }

    public function run()
    {
        return $this->render('adminSideMenu', [
            'items'=> $this->items
        ]);
    }
}