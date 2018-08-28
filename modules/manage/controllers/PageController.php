<?php

namespace app\modules\manage\controllers;

use Yii;
use app\models\Page;
use app\modules\manage\models\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for page model.
 */
class PageController extends Controller
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
     * Lists all page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single page model.
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
     * Creates a new page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $title = strip_tags($model->title);
            if(strlen($title) > 255) {
                $title = substr($title, 0, 255);
            }
            if($model->alias == '') {
                $model->alias = str_replace(' ', '-', strtolower($title));
            }
            if($model->meta_title == '') {
                $model->meta_title = $title;
            }
            if($model->meta_description == '') {
                $model->meta_description = substr(strip_tags($model->content), 0, 255);
            }
            $model->save(FALSE);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $title = strip_tags($model->title);
            if(strlen($title) > 255) {
                $title = substr($title, 0, 255);
            }
            if($model->alias == '') {
                $model->alias = str_replace(' ', '-', strtolower($title));
            }
            if($model->meta_title == '') {
                $model->meta_title = $title;
            }
            if($model->meta_description == '') {
                $model->meta_description = substr(strip_tags($model->content), 0, 255);
            }
            $model->save(FALSE);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing page model.
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
     * Finds the page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
