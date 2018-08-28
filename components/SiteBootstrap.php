<?php
namespace app\components;

use Yii;

class SiteBootstrap extends \yii\base\Component{
    public function init() {
        parent::init();
        if(!Yii::$app->user->isGuest) {
            Yii::$app->user->identity->scenario = 'update';
            Yii::$app->user->identity->last_login = time();
            Yii::$app->user->identity->save();
        }
        
        $settings = \app\models\Setting::find()->all();
        foreach ($settings as $s) {
            Yii::$app->settings->get[$s->name] = $s->value; 
        }
    }
}