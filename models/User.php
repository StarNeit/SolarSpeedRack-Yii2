<?php

namespace app\models;

use Yii;
use dektrium\user\models\Token;

class User extends \dektrium\user\models\User {

    /**
     * @var string @Password_repeat
     */
    public $password_repeat;

    public function dashboard() {
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if (empty($roles))
            return FALSE;

        $role = strtolower(current($roles)->name);
        if ($role == 'admin' || $role == 'a_staff') {
            return 'manage';
        } elseif ($role == 's_admin' || $role == 's_staff') {
            return 'account';
        } elseif ($role == 'm_admin' || $role == 'm_staff') {
            return 'dashboard';
        } elseif ($role == 'permit_uploader') {
            return '/';
        } else {
            return 'site/migrate';
        }
    }

    /**
     * Generates new username based on email address
     * if available generates new username with new number
     */
    public function generateUsername() {
        // try to use name part of email
        $this->username = explode('@', $this->email)[0];
        if ($this->validate(['username'])) {
            return;
        }
        $user = $this->username;
        $row = (new \yii\db\Query())
                ->from('{{%user}}')
                ->select('MAX(id) as id')
                ->one();
        // generate username like "user1", "user2", etc...
        while (!$this->validate(['username'])) {

            $this->username = $user . ++$row['id'];
        }
    }

    /**
     * This method is used to create new user account. If password is not set, this method will generate new 8-char
     * password. After saving user to database, this method uses mailer component to send credentials
     * (username and password) to user via email.
     *
     * @return bool
     */
//
    public function create() {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = time();
        $this->password = $this->password == null ? Password::generate(8) : $this->password;

        $this->trigger(self::BEFORE_CREATE);

        if (!$this->save()) {
            return false;
        }

//        $this->mailer->sendWelcomeMessage($this, null, true);
        $this->trigger(self::AFTER_CREATE);

        return true;
    }

    /**
     * This method is used to register new user account. If Module::enableConfirmation is set true, this method
     * will generate new confirmation token and use mailer to send it to the user. Otherwise it will log the user in.
     * If Module::enableGeneratingPassword is set true, this method will generate new 8-char password. After saving user
     * to database, this method uses mailer component to send credentials (username and password) to user via email.
     *
     * @return bool
     */
    public function register() {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $this->confirmed_at = $this->module->enableConfirmation ? null : time();
        $this->password = $this->module->enableGeneratingPassword ? Password::generate(8) : $this->password;

        if ($this->username === null) {
            $this->generateUsername();
        }
        $this->trigger(self::BEFORE_REGISTER);

        if (!$this->save()) {
            return false;
        }

        if ($this->module->enableConfirmation) {
            /** @var Token $token */
            $token = Yii::createObject(['class' => Token::className(), 'type' => Token::TYPE_CONFIRMATION]);
            $token->link('user', $this);
        }

//        $this->mailer->sendWelcomeMessage($this, isset($token) ? $token : null);
        $this->trigger(self::AFTER_REGISTER);

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember() {
        return $this->hasOne(Member::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getCards()
//    {
//        return $this->hasMany(Ccard::className(), ['user_id' => 'id'])->asArray();
//    }
//
//    public function getReviews()
//    {
//        return $this->hasMany(Review::className(), ['created_by' => 'id']);
//    }

    public function assignRole() {
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if (empty($roles))
            return FALSE;

        $role = strtolower(current($roles)->name);
        if ($role == 'admin' || $role == 'a_staff') {
            return 'manage';
        } elseif ($role == 's_admin' || $role == 's_staff') {
            return 'account';
        } elseif ($role == 'm_admin' || $role == 'm_staff') {
            return 'dashboard';
        } elseif ($role == 'permit_uploader') {
            return '/';
        } else {
            return 'site/migrate';
        }
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'password_repeat' => \Yii::t('user', 'Verify Password '),
        ];
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [ 'username', 'unique', 'message' => \Yii::t('user', 'This username has already been taken')],
            [ 'email', 'unique', 'message' =>  'This Email has already been taken'],
            ['email', 'email'],
            ['password', 'string'],
            ['password_repeat', 'required', 'on' => ['register', 'connect', 'update']],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match", 'on' => ['register', 'connect', 'create', 'update']],
        ];
    }

}
