<?php

namespace app\modules\manage\controllers;
use app\models\Setting;
use app\models\User;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        
//        $sf = \app\models\Setting::find()->where(['target'=>'shipping_fee'])->asArray()->all();
//        $time = strtotime('-3 hour');
        
        return $this->render('index', [
//            'shippingFee' => $sf,
            'recentLogins' => User::find()->where(['>', 'last_login', 0])->limit(20)->orderBy(['last_login'=>SORT_DESC])->asArray()->all()
        ]);
    }

    public function actionChangeRate()
    {
        $model = Setting::find()->where(['name'=>'global_pro_percent_value'])->one();

        if(!$model) {
            $model = new Setting();
            $model->name = 'global_pro_percent_value';
            $model->target = 'price';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->db->createCommand('UPDATE price set pro_percent=' . $model->value)->execute();
            Yii::$app->session->setFlash('success', 'Successfully Changed Pro Price Percent to ' . $model->value . '%');
            return $this->redirect(['index']);
        }

        return $this->render('update-rates', [
            'model' => $model
        ]);

    }
    public function actionUpdateShipping()
    {
        $model = new \app\modules\manage\models\ShippingSetting();
        
        if ($model->load(Yii::$app->request->post()) && $model->saveIt()) {
            Yii::$app->session->setFlash('success', 'Successfully Saved Settings!');
            return $this->redirect(['index']);
        }
        
        return $this->render('update-shipping', [
            'model' => $model
        ]);
    }
    public function actionHomeNotice()
    {
        $model = \app\models\Setting::find()->where(['name'=>'home_big_notice'])->one();

        if ($model  === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Successfully Saved.');
            return $this->redirect(['index']);
        } else {

            return $this->render('home_big_notice', [
                'model' => $model,
            ]);
        }
    }
}
