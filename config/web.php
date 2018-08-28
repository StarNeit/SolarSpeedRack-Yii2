<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'SiteBootstrap'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['awsaf', 'mike', 'shane'],
            'controllerMap' => [
                'admin' => 'app\controllers\user\AdminController',
                'profile' => 'app\controllers\user\ProfileController',
                'recovery' => 'app\controllers\user\RecoveryController',
                'registration' => 'app\controllers\user\RegistrationController',
                'security' => 'app\controllers\user\SecurityController'
            ],
            'modelMap' => [
                'User' => 'app\models\User',
                'LoginForm' => 'app\models\LoginForm',
                'Profile' => 'app\models\Profile',
                'ResendForm' => 'app\models\ResendForm',
                'RecoveryForm' => 'app\models\RecoveryForm',
                'SettingsForm' => 'app\models\SettingsForm'
            ],
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout'=>'@app/views/layouts/admin.php',
            'navbar'=> [
                ['label' => 'Home', 'url' => ['/site/index']],
            ],
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'dektrium\user\models\User',
                    'idField' => 'id'
                ]
            ],
        ],
        'manage' => [
            'class' => 'app\modules\manage\Module',
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'],
            'disabledCommands' => ['netmount'],
            'roots' => [
                [
                    'basePath'=>'@app/web',
                    'path' => 'uploads',
                    'name' => 'Global'
                ],
                [
//                    'baseUrl'=>'/',
                    'basePath'=>'@app/web',
                    'path' => 'images',
                    'name' => 'Images'
                ]
            ],
        ]
    ],
    'components' => [
        'SiteBootstrap'=>[
            'class'=>'app\components\SiteBootstrap'
        ],
        'settings' => [
            'class' => 'app\models\Setting'
        ],
        'request' => [
            'class' => 'app\components\Request',
            'cookieValidationKey' => 'RKLRNv8KZoemnXCT-7gDh2CMFiCqyceg',
            'web'=> '/web'
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'amailer' => [
            'class' => 'app\components\Mailer',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
//            'baseUrl' => '/',
            'enablePrettyUrl' => TRUE,
            'showScriptName' => FALSE,
            'rules' => [
                'contact.html' => 'site/contact',
                'about.html' => 'site/about',
                'store.html' => 'store/index',
                'calculator' => 'calculator/shift',
                [
                    'pattern' => 'calculator/<id:\d+|new>/<action:(select|print|bom|customizer)>',
                    'route' => 'calculator/index',
                    'defaults' => ['id' => 'new', 'action' => ''],
                ],
                [
                    'pattern' => 'store/<alias:[a-z\-\_]+>',
                    'route' => 'storeapp/index',//'route' => 'store/browse', //old store pages disabled
                    'suffix' => '.html',
                ],
                [
                    'pattern' => 'store/product/<id:\d+>',
                    'route' => 'store/product'
                ],
                [
                    'pattern' => '<alias:[a-z\-\_]+>',
                    'route' => 'page/view',
                    'suffix' => '.html',
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
            'class' => '\rmrevin\yii\minify\View',
            'enableMinify' => !YII_DEBUG,
            'web_path' => '@web', // path alias to web base
            'base_path' => '@webroot', // path alias to web base
            'minify_path' => '@webroot/css/minify', // path alias to save minify result
            'js_position' => [ \yii\web\View::POS_END ], // positions of js files to be minified
            'force_charset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expand_imports' => true, // whether to change @import on content
            'compress_output' => true, // compress result html page
            'compress_options' => ['extra' => true], // options for compress
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'excludeBundles' => [
//                \app\assets\Angular_appAsset::class, // exclude this bundle from minification
//                \app\assets\AdminAsset::class,
//                \app\assets\AdminLTEAsset::class,
                \app\assets\NewDesignAsset::class,
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LfdqRoUAAAAADL1CQ3WvyzTOSgUPM3BgGew58Zb',
            'secret' => '6LfdqRoUAAAAAKx__Qb8CO-hw_WUm9fAhZ2afxX5',
        ],
        'Yii2Twilio' => [
            'class' => 'filipajdacic\yiitwilio\YiiTwilio',
            'account_sid' => 'AC2127f1e06115a62dfb192bb938c2ad53',
            'auth_key' => '6c615c355a01695f5964a4002794325f', 
        ],
        'client' => [
            'class' => 'Twilio\Rest\Client'
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'admin/*',
            'site/*',
            'store/index',
            'store/browse',
            'store/product',
            'store/cart',
            'store/search',
            'store/add-to-cart',
            'store/change-cart',
            'store/remove-from-cart',
            'store/refresh',
            'store/beta-disclaimer',
            'tool/beta-disclaimer',
            'tool/new',
            'tool/get',
            'tool/save',
            'tool/newuser',
            'page/*',
            'debug/*',
            'gii/*',
            'users/*',
            'user/security/*',
            'user/registration/*',
            'user/recovery/*',
            'storeapp/*',
            'products/*',
            'manage/product/update_prices_cron'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
