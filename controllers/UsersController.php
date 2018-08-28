<?php

namespace app\controllers;
use app\models\Profile;
use app\models\User;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UsersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMemberSignUp()
    {
        $profile = new Profile();
        $user = new User();

        if (\Yii::$app->request->isAjax && $user->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        if ($user->load(\Yii::$app->request->post()) && $profile->load(\Yii::$app->request->post())) {
            if ($user->validate() && $user->save()){

                $user->assignRole('member', $user->getPrimaryKey());//assign role member

                $profile->user_id = $user->getPrimaryKey();

                if($profile->validate() && $profile->save()){
                    //profile saved successfully
                } else {
                    //todo profile error to log file
                }
                \Yii::$app->session->setFlash('Account created successfully');

                return $this->goHome();

            } else {
                \Yii::$app->session->setFlash('User was not saved please contact to Administrator or try again');
                return $this->refresh();
                //todo user error to log file
            }
        }//end post

        return $this->render('member-sign-up', [
            'model' => $profile,
            'user' => $user
        ]);
    }

    public function actionDashboard(){

        return $this->render('dashboard', [

        ]);
    }


}
