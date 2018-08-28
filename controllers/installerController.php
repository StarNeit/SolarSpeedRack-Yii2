<?php

namespace app\controllers;

use Yii;
use app\models\ProjectDetails;
use app\models\ProjectDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class InstallerController extends \yii\web\Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
//         if (Yii::$app->user->can('installer')) {
      
         /**
         * @Query for Inspection 
         */
        $searchModel = new ProjectDetailsSearch();
        $query = ProjectDetailsSearch::find();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andWhere(' (inspection_status =1 OR inspection_status = 2 ) AND  installer_id ='.Yii::$app->user->getId());
        /**
         * @Query for Installation 
         */
        $installation_query = ProjectDetailsSearch::find();
        $installation_searchModel = new ProjectDetailsSearch();
        $installation_dataProvider = $installation_searchModel->search(Yii::$app->request->queryParams);
         $installation_dataProvider = new ActiveDataProvider([
            'query' => $installation_query,
        ]);
        $installation_query->andWhere(' (installation_status =1 OR installation_status = 2 or installation_status = 3 ) AND  inspection_status = 3 AND  installer_id ='.Yii::$app->user->getId());
         

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'inspection_dataProvider' => $dataProvider,
                    'installation_dataProvider' => $installation_dataProvider,
        ]);
//        }
    }

    /**
     * Displays a single ProjectDetails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
/**
 * @tutorial InstallerController  inspection confirmed
 */
    public function actionConfirm($id) {
        $model = $this->findModel($id); 
        if ($model->load(Yii::$app->request->post())) {
            $model->inspection_status =ProjectDetails::INSPECTION_CONFIRMED;
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('confirm', [
                        'model' => $model,
            ]);
        }
    }
/**
 * @tutorial InstallerController  inspection confiration changed
 */
    public function actionChange($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->inspection_status = ProjectDetails::INSPECTION_CONFIRMED;
            $model->inspection_time = strtotime($model->inspection_time);
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('change', [
                        'model' => $model,
            ]);
        }
    }

    
    /**
     *  Project convet form inspection to installation 
     */
     public function actionAssign($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->inspection_status = ProjectDetails::INSPECTION_DONE;           
            $model->installation_time = strtotime($model->installation_time);
            
            
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('assign', [
                        'model' => $model,
            ]);
        }
    }
    
    /**
     * Finds the ProjectDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProjectDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
