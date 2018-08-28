<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers\user;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use dektrium\user\controllers\SecurityController as BaseSecurityController;

/**
 * ProfileController shows users profiles.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SecurityController extends BaseSecurityController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login', 'auth', 'blocked', 'tool'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['login', 'auth', 'logout'], 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Displays the login page.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);
        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {

            $cookies = Yii::$app->request->cookies;

            if ($cookies->has('project_id')) {
                $project = \app\models\Project::findOne($cookies['project_id']->value);
                if($project && !$project->created_by) {
                    $project->created_by = Yii::$app->user->id;
                    $project->updated_by = Yii::$app->user->id;
                    $project->save();
                }
                Yii::$app->response->cookies->remove('project_id');
            }
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);

            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
    
    public function actionTool()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/tool/new');
        }

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);
        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {

            $cookies = Yii::$app->request->cookies;

            if ($cookies->has('project_id') && Yii::$app->user->identity->member) {
                $project = \app\models\Project::findOne($cookies['project_id']->value);
                if($project && !$project->created_by) {
                    $project->created_by = Yii::$app->user->id;
                    $project->updated_by = Yii::$app->user->id;
                    $project->save();
                }
                Yii::$app->response->cookies->remove('project_id');
            }
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);

            return $this->goBack();
            
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }
}