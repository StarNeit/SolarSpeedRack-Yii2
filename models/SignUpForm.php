<?php // 

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Description of MemberSignUpForm
 *
 * @author Awsaf
 */
class SignUpForm extends Model 
{
    
    public $logo;
    
    /** @var string */
    public $email;

    /** @var string */
    public $password;
    
    /** @var string */
    public $verifyPassword;

    public $verifyCode;
    
    /** @var User */
    public $user;

    /** @var Module */
    protected $module;
    
    
    /** @inheritdoc */
    public function init()
    {
        $this->user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'register'
        ]);
        $this->module = \Yii::$app->getModule('user');
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['email', 'password', 'verifyPassword'], 'required'],
            [['email'], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            [['logo'], 'file', 'extensions'=>'jpeg, jpg, gif, png'],
            [['email'], 'unique', 'targetClass' => User::className(),
                'message' => 'This email has already been taken'],
            ['password', 'string', 'min' => 6],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password'],
//            [['verifyCode'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className()]//
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        
        return [
            'email'    => 'Email',
            'password' => 'Password',
            'verifyPassword' => 'Verify Password',
            'verifyCode' => 'Captcha',
        ];
    }
    
    /** @inheritdoc */
    public function formName()
    {
        return 'member-register-form';
    }

    /**
     * Registers a new user account.
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->setAttributes([
            'email'    => $this->email,
            'password' => $this->password
        ]);

        return $this->user->register();
    }
}