<?php

namespace app\controllers;

use app\models\Common;
use app\models\ProjectActivity;
use yii\db\Command;
use yii\swiftmailer\Message;

class MessageController extends \yii\web\Controller
{
    public function actionNotifications()
    {
        $model = \app\models\Message::find()->where(['to_user_id' => \Yii::$app->user->getId(), 'type' => \app\models\Message::NOTIFICATION])->all();

        \app\models\Message::updateAll(['mark_read' => 2], 'mark_read = 1');//todo marked read particular message

        return $this->render('notifications',[
            'model' => $model
        ]);
    }

    /**
     *
     */
    public function actionSendInspectionRequest()
    {
        $status = 'fail';
        $post = \Yii::$app->request->post();

        $pid = $post['id'];
        $date = $post['msg'];
        $projectActivity = ProjectActivity::find()->where(['id' => $pid])->one();

        if(!$projectActivity) {
            echo json_encode(['status' => $status]);
            return;
        }

        $message = new \app\models\Message();
        $message->user_id = \Yii::$app->user->getId();
        $msg = 'Inspection (id:'.$projectActivity->id.') Request time is: ' . $date;
        $message->message = $msg;
        $message->activity_id = $projectActivity->activity_id; //inspection
        $message->project_id = $projectActivity->project_rec_id;
        $message->to_user_id = $projectActivity->projectRec->installer_id;
        $message->save();

        if (!$message->hasErrors()){
            Common::sendEmail(\Yii::$app->user->identity->email, 'Inspection Request', $msg);

            $projectActivity->done_percent = 50;
            $projectActivity->status = ProjectActivity::INSPECTION_WAIT_INSTALLER;
            $projectActivity->notes_customer = 'Requested time: '.$date.' Waiting from installer inspection confirmation';
            $projectActivity->notes_installer = 'Requested time: '.$date.' Your project has been assign for Inspection, please confirm customer appointments or change it';
            $projectActivity->save();

            $status = 'success';
        } else {
            \Yii::trace('Message send error');
        }

        echo json_encode(['status' => $status]);
    }

    public function actionConfirmInspectionRequest()
    {
        $status = 'fail';
        $activity_id = 6;//inspection
        $post = \Yii::$app->request->post();

        $pid = $post['id'];

        $projectActivity = ProjectActivity::find()->where(['project_rec_id' => $pid, 'activity_id' => $activity_id])->one();

        if(!$projectActivity) {
            echo json_encode(['status' => $status]);
            return;
        }

        $message = new \app\models\Message();
        $message->user_id = \Yii::$app->user->getId();
        $msg = 'Inspection Confirmed';
        $message->message = $msg;
        $message->activity_id = $activity_id;
        $message->project_id = $pid;
        $message->to_user_id = $projectActivity->projectRec->user_id;
        $message->save();

        if (!$message->hasErrors()){
            Common::sendEmail('customer1@user124.com', 'Inspection Confirmed', $msg);//todo insert customer email

            $projectActivity->done_percent = 100;
            $projectActivity->status = ProjectActivity::INSPECTION_APROVED;
            $projectActivity->notes_customer = $projectActivity->notes_installer = 'Inspection Confirmed';
            $projectActivity->save();

            $status = 'success';
        } else {
            \Yii::trace('Message send error');
        }

        echo json_encode(['status' => $status]);
    }

}
