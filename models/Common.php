<?php

namespace app\models;

use Yii;
use yii\base\Model;


class Common
{

    public static function sendEmail($to, $subject, $body)
    {
        Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }
}
