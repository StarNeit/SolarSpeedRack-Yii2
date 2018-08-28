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
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;
use dektrium\user\models\Token;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

/**
 * ProfileController shows users profiles.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationController extends BaseRegistrationController
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['register', 'member-sign-up', 'supplier-sign-up', 'connect'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['confirm', 'resend'], 'roles' => ['?', '@']],
                ]
            ],
        ];
    }
    public function actionRegister()
    {
        $this->redirect(['/user/login']);
    }
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise redirects to home page.
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionMemberSignUp()
    {        
        $model = new \app\models\SignUpForm();
        $profile = new \app\models\Profile();

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(\Yii::$app->request->post()) && $profile->load(\Yii::$app->request->post())) {
            if ($model->validate() && $model->register()){

                if($model->user->profile) {
                    $model->user->profile->load(\Yii::$app->request->post());
                    $model->user->profile->save();
                } else {
                    $profile->user_id = $model->user->id;

                    if($profile->validate() && $profile->save()){
                        //profile saved successfully
                    } else {
                        //todo profile error to log file
                    }
                }
                \Yii::$app->session->setFlash('Account created successfully');

//                $auth = Yii::$app->authManager;
//                $role = $auth->getRole('member');
//                $auth->assign($role, $model->user->id);

                $cookies = Yii::$app->request->cookies;

                if ($cookies->has('project_id')) {
                    $project = \app\models\Project::findOne($cookies['project_id']->value);
                    if($project && !$project->created_by) {
                        $project->created_by = $model->user->id;
                        $project->updated_by = $model->user->id;
                        $project->save();
                    }
                    Yii::$app->response->cookies->remove('project_id');
                }
//                $this->sendMails($model->user);

                Yii::$app->session->setFlash('info', 'Thank you for submitting your membership application, please check your email to activate your account.');

                return $this->render('/message', [
                    'title'  => Yii::t('user', 'Your account has been created'),
                    'module' => $this->module,
                    'modal' => [
                        'title' => 'Please check your email to activate your account',
                        'body' => 'Thank you for submitting your membership application, please check your email to activate your account!'
                    ]
                ]);

            } else {
                \Yii::$app->session->setFlash('User was not saved please contact to Administrator or try again');
                return $this->refresh();
                //todo user error to log file
            }
        }
//        $terms = \app\models\Page::find()->where(['alias'=>'terms-and-conditions'])->one();
        
        return $this->render('member', [
            'model'  => $model,
            'profile'  => $profile,
            'module' => $this->module,
        ]);
    }
    public function actionSupplierSignUp()
    {
        $model = new \app\models\SignUpForm();
        $supplier = new \app\models\Supplier();
        $address = new \app\models\SupplierAddress();
        $company = new \app\models\SupplierCompany();
        $supplier->user_id = 1;
        $supplier->company_id = 1;
        $address->is_default = 1;
        $address->company_id = 1;
        
        if (
            $model->load(Yii::$app->request->post()) &&
            $address->load(Yii::$app->request->post()) &&
            $company->load(Yii::$app->request->post()) &&
            $model->register() &&
            $address->validate() &&
            $company->validate() 
        ) {
            $supplier->load(Yii::$app->request->post());
            $company->save(false);
            
            if(is_array($supplier->requests) && !empty($supplier->requests)) {
                $supplier->requested_categories = implode(', ', $supplier->requests);
            }
            $supplier->user_id = $model->user->id;
            $supplier->created_by = $model->user->id;
            
            $supplier->company_id = $company->id;
            
            $supplier->save(false);
            
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('s_admin');
            $auth->assign($role, $model->user->id);
            
            $address->company_id = $company->id;
            $address->save(false);
            
            $model->user->profile->first_name = $address->first_name;
            $model->user->profile->last_name = $address->last_name;
            $model->user->profile->address1 = $address->address1;
            $model->user->profile->address2 = $address->address2;
            $model->user->profile->office_number = $address->office_number;
            $model->user->profile->contact_number = $address->contact_number;
            $model->user->profile->city = $address->city;
            $model->user->profile->state = $address->state;
            $model->user->profile->zip_code = $address->zip_code;
            $model->user->profile->country = $address->country;
            $model->user->profile->save(FALSE);
            
            $imageFile = UploadedFile::getInstance($model, 'logo');
            if($imageFile) {
                $company->getBehavior('logo')->setImage($imageFile->tempName);
            }
            $this->sendMails($model->user, 'Supplier');
            Yii::$app->session->setFlash('info', 'Thank you for your application, one of our account managers will contact you soon.');
            
            return $this->render('/message', [
                'title'  => Yii::t('user', 'Your account has been created'),
                'module' => $this->module,
            ]);
            
        }

        return $this->render('supplier', [
            'model'  => $model,
            'supplier'  => $supplier,
            'address'  => $address,
            'company'  => $company,
            'module' => $this->module,
        ]);
    }
    protected function sendMails($user, $type = 'Member') 
    {
        $token = \Yii::createObject([
            'class' => Token::className(),
            'type'  => Token::TYPE_CONFIRMATION,
        ]);
        $token->link('user', $user);

        if($type == 'Member') {
            Yii::$app->amailer->send($user->email, 'Registration', ['user_name' => $user->username, 'activation_url'=> $token->url]);
        }

        Yii::$app->amailer->send('sales@nsscgroup.com', 'NewUserAdmin', ['user_name'=>$user->username, 'member_type'=>$type]);
    }
    
}
