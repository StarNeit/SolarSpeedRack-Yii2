<?php

/* 
 * This file is part of the Dektrium project
 * 
 * (c) Dektrium project <http://github.com/dektrium>
 * 
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px'
    ],
    'items' => [
        [
            'label'   => Yii::t('user', 'Users'),
            'url'     => ['/user/admin/index'],
        ],
        [
            'label' => Yii::t('user', 'Create New User'),
            'url'     => ['/user/admin/create']
        ],
        [
            'label'   => Yii::t('user', 'Download'),
            'items' => [
                [
                    'label' => 'Members',
                    'url'     => ['/user/admin/dldmember'],
                ],
                [
                    'label' => 'Suppliers',
                    'url'     => ['/user/admin/dldsupplier'],
                ],
                [
                    'label' => 'All User',
                    'url'     => ['/user/admin/dldall'],
                ]
            ],
        ],
    ]
]) ?>
