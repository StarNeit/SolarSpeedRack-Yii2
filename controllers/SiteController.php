<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Profile;
use app\models\User;
use yii\web\Response;
use yii\widgets\ActiveForm;
// Required if your environment does not handle autoloading
require __DIR__ . '/../vendor/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

class SiteController extends Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $this->layout = 'main-home';

        $profile = new Profile();
        $user = new User(['scenario' =>'create']);
        if (\Yii::$app->request->isAjax && $user->load(\Yii::$app->request->post()) && $profile->load(\Yii::$app->request->post())) {

            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        if ($user->load(\Yii::$app->request->post()) && $profile->load(\Yii::$app->request->post())) {
            if ($user->validate() && $user->save()) {

                $user->assignRole('member', $user->getPrimaryKey()); //assign role member

                $profile->user_id = $user->getPrimaryKey();

                if ($profile->validate() && $profile->save()) {
                    //profile saved successfully
                } else {
                    //todo profile error to log file
                }
                \Yii::$app->session->setFlash('Account created successfully');

                return $this->goHome();
            } else {
                \Yii::$app->session->setFlash('User was not saved please contact to Administrator or try again');
                \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
//                return $this->refresh();
                //todo user error to log file
            }
        }

        return $this->render('index', [
                    'profile' => $profile,
                    'user' => $user
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            return $this->redirect('/user/login');
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     * 4
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

    public function actionFinanceOptions() {

        return $this->render('finance-options', [
                        // 'model' => $model,
        ]);
    }

    public function actionSendemail(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $email= explode(":", $data['email']);
            $email= $email[0];
            if(!isset($email)) {
                $code = 1000;//email is not set
            }

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= "From: OneClickSolar" . "\r\n";

            $code = mail($email,'Solar Speed Rack Verification',"Verification Code: ".rand(10000,99999),$headers);
            $code = $code ? 2000 : 3000;
            //2000: success, 1000: failed
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $code,
            ];
        }
    }

    public function actionSolarapi2()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $address= explode(":", $data['address']);
            $address= $address[0];
            if(!isset($address)) {
                $address = '2615 Orange Ave, Santa Ana, CA 92707';
            }
            $apiKey = 'XwuJG0ZQoK85CejNNP03spGc7TIGHICQVPuTWStJ';

            $ch = curl_init();
            $url = 'http://developer.nrel.gov/api/utility_rates/v3.json';
            $url .= '?';
            //$url .= "format=json&";
            $url .= "api_key={$apiKey}&";
            $url .= "address=" . urlencode($address) . '&';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $ratesReturn = curl_exec($ch);
            curl_close($ch);
            unset($ch);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'ratesratesReturn' => $ratesReturn,
            ];
          }
    }

    public function actionSolarapi()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();

            $address= explode(":", $data['address']);
            $address= $address[0];
            if(!isset($address)) {
                $address = '2615 Orange Ave, Santa Ana, CA 92707';
            }

            $system_capacity= explode(":", $data['system_capacity']);
            $system_capacity= $system_capacity[0];
            if(!isset($system_capacity)) {
                $system_capacity = 0;
            }

            $azimuth= explode(":", $data['azimuth']);
            $azimuth= $azimuth[0];
            if(!isset($azimuth)) {
                $azimuth = 0;
            }
               
            $tilt= explode(":", $data['tilt']);
            $tilt= $tilt[0];
            if(!isset($tilt)) {
                $tilt = 0;
            }

            $module_type= explode(":", $data['module_type']);
            $module_type = $module_type[0];
            if(!isset($module_type)){
                $module_type = 0;
            }

            $losses = explode(":", $data['system_lose']);
            $losses = $losses[0];
            if(!isset($losses)){
                $losses = 0;
            }

            $array_type = 1;
            $apiKey = 'XwuJG0ZQoK85CejNNP03spGc7TIGHICQVPuTWStJ';

            $ch = curl_init();
            $url = 'http://developer.nrel.gov/api/pvwatts/v5.json';
            $url .= '?';
            //$url .= "format=json&";
            $url .= "api_key={$apiKey}&";
            $url .= "address=" . urlencode($address) . '&';
            $url .= "system_capacity=".$system_capacity."&";
            $url .= "azimuth=".$azimuth."&";
            $url .= "tilt=".$tilt."&";
            $url .= "array_type=".$array_type."&";
            $url .= "module_type=".$module_type."&";
            $url .= "losses=".$losses;
            //$url .= "lat={$lat}";
            //$url .= "lon={$lon}";
            //$url .= "radius=100";
            //$url .= "all";

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $returnPvWatts = curl_exec($ch);
            curl_close($ch);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'search' => $returnPvWatts,
            ];
          }
    }

    public function actionTest()
    {
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC2127f1e06115a62dfb192bb938c2ad53';
        $token = '6c615c355a01695f5964a4002794325f';
        $client = new Client($sid, $token);
        // $client = new Yii::$app->client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            '+11234567890',
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+13233125150',
                // the body of the text message you'd like to send
                'body' => 'Hey LodeStar!!!!! Good luck on the bar exam!'
            )
        );
    }

    public function actionSendsms()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $result = 0;        
            $number= explode(":", $data['number']);
            $number= $number[0];
            if(!isset($number)) {
                $result = -1;
            }
            if ($result != -1){
                try{
                    // Your Account SID and Auth Token from twilio.com/console
                    $sid = 'AC2127f1e06115a62dfb192bb938c2ad53';
                    $token = '6c615c355a01695f5964a4002794325f';
                    $client = new Client($sid, $token);

                    // Use the client to do fun stuff like send text messages!
                    $client->messages->create(
                        // the number you'd like to send the message to
                        "+1".$number,
                        array(
                            // A Twilio phone number you purchased at twilio.com/console
                            'from' => '+13233125150',
                            // the body of the text message you'd like to send
                            'body' => 'Verification Code: '.mt_rand(10000, 99999)
                        )
                    );
                    $result = 1;
                }catch(Exception $e){
                    $result = -1;
                }
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'return_code' => $result,
            ];
        }
    }
}
