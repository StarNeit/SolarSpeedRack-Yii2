<?php

namespace app\modules\manage\controllers;

use Yii;
use app\models\Accessory;
use app\models\AccessoryProduct;
use app\modules\manage\models\AccessorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccessoryController implements the CRUD actions for Accessory model.
 */
class AccessoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Accessory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccessorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Accessory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Accessory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Accessory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'products' => \app\models\Product::listAll(),
            ]);
        }
    }

    /**
     * Updates an existing Accessory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'products' => \app\models\Product::listAll(),
            ]);
        }
    }

    /**
     * Deletes an existing Accessory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAddProduct($id)
    {
        $accessory = $this->findModel($id);
        $model = new AccessoryProduct();
        $model->accessory_id = $accessory->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Success!');
            return $this->redirect(['update', 'id'=>$id]);
        } else {
            Yii::$app->session->setFlash('error', 'Error!');
            return $this->redirect(['update', 'id'=>$id]);
        }
    }

    public function actionDeleteLink($id)
    {
        $aid = false;
        if(Yii::$app->request->isPost) {
            $al = AccessoryProduct::findOne($id);
            if($al) {
                $aid = $al->accessory_id;
                $al->delete();
                Yii::$app->session->setFlash('success', 'Success!');
                return $this->redirect(['update', 'id'=>$aid]);
            }
        }
        Yii::$app->session->setFlash('error', 'Error!');
        if($aid) {
            return $this->redirect(['update', 'id'=>$aid]);
        } else {
            return $this->redirect('index');
        }
    }

    /**
     * Finds the Accessory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Accessory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Accessory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
