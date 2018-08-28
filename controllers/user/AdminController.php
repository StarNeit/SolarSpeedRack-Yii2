<?php

namespace app\controllers\user;

use Yii;
use app\models\UserSearch;
use dektrium\user\controllers\AdminController as BaseAdminController;
use yii\helpers\Url;

class AdminController extends BaseAdminController
{
    public $layout = '//admin';
    
    public function actionDldmember()
    {
        $products = (new \yii\db\Query())
                ->from('member m')
                ->select(["Username"=> "u.username", "First Name"=> "p.first_name", "Last Name"=> "p.last_name", "Email"=> "u.email", "Company"=> "mc.name" ])
                ->leftJoin('m_company mc', 'm.company_id = mc.id')
                ->leftJoin('user u', 'm.user_id = u.id')
                ->leftJoin('profile p', 'm.user_id = p.user_id')
                ->orderBy(['m.id'=>SORT_ASC])
                ->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=members.csv');

        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array_keys($products[0]));
        foreach($products as $product) {
            fputcsv($output, array_values($product));
        }
    }

    public function actionDldall()
    {
        $users = (new \yii\db\Query())
            ->from('user u')
            ->select(["Username"=> "u.username", "First Name"=> "p.first_name", "Last Name"=> "p.last_name", "Email"=> "u.email"])
            ->leftJoin('profile p', 'u.id = p.user_id')
            ->orderBy(['u.id'=>SORT_ASC])
            ->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=nsscusers.csv');

        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array_keys($users[0]));
        foreach($users as $user) {
            fputcsv($output, array_values($user));
        }
    }
    /**
     * Confirms the User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $event = $this->getUserEvent($model);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
        $model->confirm();
        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been confirmed'));

        return $this->redirect('index');
    }
    public function actionDldsupplier()
    {
        $products = (new \yii\db\Query())
                ->from('supplier m')
                ->select(["Username"=> "u.username", "First Name"=> "p.first_name", "Last Name"=> "p.last_name", "Email"=> "u.email", "Company"=> "mc.name", ])
                ->leftJoin('s_company mc', 'm.company_id = mc.id')
                ->leftJoin('user u', 'm.user_id = u.id')
                ->leftJoin('profile p', 'm.user_id = p.user_id')
                ->orderBy(['m.id'=>SORT_ASC])
                ->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=suppliers.csv');

        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array_keys($products[0]));
        foreach($products as $product) {
            fputcsv($output, array_values($product));
        }
    }
    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $dataProvider->sort->defaultOrder = [
                    'id' => SORT_DESC
                ];
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
    
    
    public function actionSendConfirmMail($id)
    {
        $user = $this->findModel($id);
        
        /** @var Token $token */
        $token = \Yii::createObject([
            'class'   => \dektrium\user\models\Token::className(),
            'user_id' => $user->id,
            'type'    => \dektrium\user\models\Token::TYPE_CONFIRMATION,
        ]);
        $token->save(false);
        Yii::$app->amailer->send($user->email, 'ResendConfirmation', ['user_name' => $user->username, 'activation_url'=> $token->url]);
        \Yii::$app->session->setFlash('success', 'Successfully Send.');
        return $this->redirect('/user/admin');
    }

    /**
     * Updates an existing User model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);

        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Account details have been updated'));
            $this->trigger(self::EVENT_AFTER_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('_account', [
            'user' => $user,
        ]);
    }

    /**
     * Shows information about user.
     *
     * @param int $id
     *
     * @return string
     */
    public function actionInfo($id)
    {
        $user = $this->findModel($id);
        
        return $this->render('_info', [
            'user' => $user,
        ]);
    }
    
    
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id == Yii::$app->user->getId()) {
            Yii::$app->getSession()->setFlash('danger', 'You can not remove your own account');
        } else if ($id == 1) {
            Yii::$app->getSession()->setFlash('danger', 'Sorry Something went wrong.');
        } else {
            $supplier = \app\models\Supplier::find()->where(['user_id'=>  $id])->one();
            if($supplier !== null) {
                $supplier->delete();
            }
            $member = \app\models\Member::find()->where(['user_id'=>  $id])->one();
            if($member !== null) {
                Yii::$app->db->createCommand('DELETE FROM `' . \app\models\History::tableName() . '` where `member_id` = ' . $member->id)->execute();
                $member->delete();
            }
            
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been deleted'));
        }
        
        return $this->redirect(['index']);
    }
}