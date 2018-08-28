<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

//running yii rbac/init
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $installer = $auth->createRole('installer');
        $auth->add($installer);

        $member = $auth->createRole('member');
        $auth->add($member);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $member);
        $auth->addChild($admin, $installer);

        $auth->assign($installer, 3);
        $auth->assign($member, 2);
        $auth->assign($admin, 1);
    }
}