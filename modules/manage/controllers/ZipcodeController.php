<?php

namespace app\modules\manage\controllers;

use Yii;
use app\models\ZipCode;
use app\modules\manage\models\ZipcodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ZipcodeController implements the CRUD actions for ZipCode model.
 */
class ZipcodeController extends Controller
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
     * Lists all ZipCode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZipcodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 
     * Displays a single ZipCode model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $searchModel = new \app\modules\manage\models\MetadataSearch();
        $searchModel->zip_code_id = $id;
        $dataProvider = $searchModel->search([]);
        
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ZipCode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZipCode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionCreateMeta($id)
    {
        $model = new \app\models\Metadata();
        $model->zip_code_id = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->zip_code_id]);
        } else {
            return $this->render('create_meta', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdateMeta($id)
    {
        if (($model = \app\models\Metadata::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->zip_code_id]);
        } else {
            return $this->render('update_meta', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ZipCode model.
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
            ]);
        }
    }

    /**
     * Deletes an existing ZipCode model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->db->createCommand('DELETE FROM `metadata` WHERE zip_code_id = ' . $id)->execute();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ZipCode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZipCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZipCode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionImportca()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);
        
        $done = $notdone = 0;
        
        if (isset($_FILES['csv']['size']) && $_FILES['csv']['size'] > 0) {
            
            $file = $_FILES['csv']['tmp_name']; 
            
            if (($handle = fopen($file, "r")) !== FALSE)
            {
                $length = 1000;
                $delimiter = ",";
                $i = 1;
                $count = 1;
                ini_set('memory_limit', '512M');
                set_time_limit(0);
                
                $cellTechs = [];
                while ( $data = fgetcsv( $handle, $length, $delimiter ) )
                {          
                    if($i < 16)
                    {
                        $i++;
                    } else {
                        $model = ZipCode::find()->where(['code'=>$data[2]])->one();
                        if(!$model) {
                            $model = new ZipCode();
                            $model->code = (int) $data[2];
                            $model->city = str_replace('*', '', $data[1]);
                            $model->state = 'CA';
                        }
                        $model->tax_rate = str_replace('%', '', $data[6]);
                        if(!$model->save()){
                            echo '<pre>';
                            print_r($model);
                            exit;
                        }
                    }
                }
            }
            Yii::$app->session->setFlash('success', 'Zip codes updated successfully.');
            return $this->redirect(['index']);
        }
        return $this->render('update_csv', [
        ]);
    }
}
