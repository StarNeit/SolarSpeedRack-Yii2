<?php

namespace app\controllers;

use app\models\ProjectActivity;
use Yii;
use app\models\ProjectRecord;
use app\models\ProjectRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectRecordController implements the CRUD actions for ProjectRecord model.
 */
class ProjectRecordController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProjectRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('member')) {
            $model = ProjectRecord::find()->all();//todo add customer id

            return $this->render('index_customer', [
                'model' => $model,
            ]);
        } elseif (Yii::$app->user->can('installer')){
            $clients = ProjectRecord::find()->where(['installer_id' => Yii::$app->user->getId()])->all();

            return $this->render('index_installer', [
                'clients' => $clients,
            ]);
        }
    }

    /**
     * Displays a single ProjectRecord model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('member')) {

            $model = $this->findModel($id);
            $inspection = ProjectActivity::obtainActivity($model->id, 6);

            return $this->render('view_customer', [
                'model' => $model,
                'data' => ['inspection' => $inspection]
            ]);
        } elseif (Yii::$app->user->can('installer')){
            $model = $this->findModel($id);
            $inspection = ProjectActivity::obtainActivity($model->id, 6);

            return $this->render('view_installer', [
                'model' => $model,
                'data' => ['inspection' => $inspection]
            ]);
        }


    }

    /**
     * Creates a new ProjectRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectRecord();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectRecord model.
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
     * Deletes an existing ProjectRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
