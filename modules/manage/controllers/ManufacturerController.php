<?php

namespace app\modules\manage\controllers;

use Yii;
use app\models\Manufacturer;
use app\modules\manage\models\ManufacturerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManufacturerController implements the CRUD actions for PvManufacturer model.
 */
class ManufacturerController extends Controller
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
     * Lists all PvManufacturer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManufacturerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionMulDelete()
    {
        $pk = Yii::$app->request->post('row_id');

        foreach ($pk as $key => $value) 
        {
            $sql = "DELETE FROM " . Manufacturer::tableName() . " WHERE id = $value";
            Yii::$app->db->createCommand($sql)->execute();
        }

        return $this->redirect(['index']);

    }


    /**
     * Creates a new PvManufacturer model.
     * If creation is successful, the browser will be redirected to the PvManufacturer 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufacturer();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PvManufacturer model.
     * If update is successful, the Manufacturer JSON list will be updated and
     * browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->featured > 0) {
                foreach($model->products as $product) {
                    $product->order = $model->featured;
                    $product->save();
                }
            }
            Yii::$app->session->setFlash('success', 'Successfully updated');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PvManufacturer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        PvManufacturer::generateJSON();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PvManufacturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PvManufacturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manufacturer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
