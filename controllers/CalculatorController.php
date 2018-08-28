<?php

namespace app\controllers;

use app\models\Product;
use Yii;

use app\models\Project;
use app\models\ProjectPart;
use app\models\ProjectSearch;
use app\models\Accessory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Company;


/**
 * PageController implements the CRUD actions for page model.
 */
class CalculatorController extends Controller
{
    
    protected $member;
    
    public function beforeAction($action) {
        parent::beforeAction($action);
        if(YII::$app->user->isGuest || Yii::$app->user->can('all')) {
            return true;
        }
        $this->member = \app\models\Member::find()->where(['user_id'=>  Yii::$app->user->id])->with(['company', 'company.address'])->one();
        
        if($this->member !== null && ($this->member->company->status == Company::STATUS_ON_HOLD)) {
                return $this->redirect('/dashboard/index');
        } elseif($this->member !== null) {
            if($this->member->company->checkValidity()) {
                return $this->member;
            } else {
                return $this->refresh();
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('This area is only for Members.');
        }
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'deletesm' => ['post']
                ]
            ]
        ];
    }

    public function actionMap()
    {
        $model = new \stdClass();
        $model->lat = 33.696031;
        $model->lng = -117.900018;
        return $this->render('map', ['model'=> $model]);
    }

    public function actionGetbom($id)
    {
        $project = $this->findModel($id);
        echo '<pre>';
        // $config = json_decode($project->config);
        print_r($project->layout);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {

        $this->layout = "//newtool";
        
        return $this->render('index');
    }

    public function actionShift()
    {
        return $this->redirect('/calculator/new');
    }

    /**
     * Displays a single page model. 
     * @throws \yii\web\ForbiddenHttpException
     * @internal param int $id
     */
    public function actionGetParts()
    {

        $this->layout = "//newtool";

        return $this->render('index');
    }
    
    public function actionBetaDisclaimer() 
    {
        if(Yii::$app->request->post()) {
            $a = (int) Yii::$app->request->post('agree');
            if($a > 0) {
                Yii::$app->session['disclaimer'] = true;
//                Yii::$app->user->identity->disclaimer = 1;
//                Yii::$app->user->identity->save(false);
                return $this->redirect('new');
            } else {
                return $this->redirect('/');
            }
        }
        return $this->render('beta');
    }
    
    public function actionSave()
    {
        if(
            Yii::$app->request->isAjax
            && isset($_POST['id'], $_POST['totalWatts'], $_POST['costPerWatt'], $_POST['costPerPanel'])
            && Yii::$app->request->post('config')
            && Yii::$app->request->post('layouts')
        ) {
            $id = (int) Yii::$app->request->post('id');
            
//            $parts = Yii::$app->request->post('parts');
            $config = Yii::$app->request->post('config');
            $layout = Yii::$app->request->post('layouts');
            $mainCsvData = Yii::$app->request->post('mainCsvData');
            
            if($id > 0) {
                $model = $this->findModel($id);
                $model->updated_by = Yii::$app->user->id;
            } else {
                $model = new Project();
                if(!Yii::$app->user->isGuest) {
                    $model->created_by = Yii::$app->user->id;
                    $model->updated_by = Yii::$app->user->id;
                } else {
                    $model->created_by = 0;
                    $model->updated_by = 0;
                }
            }
            $model->name = Yii::$app->request->post('name');
            $model->zip_code = Yii::$app->request->post('zip') ? Yii::$app->request->post('zip') : '';
            
            $model->total_watt = (string) floatval(Yii::$app->request->post('totalWatts'));
            $model->total_material = '0';
            $model->cost_per_watt = (string) floatval(Yii::$app->request->post('costPerWatt'));
            $model->cost_per_panel = (string) floatval(Yii::$app->request->post('costPerPanel'));

            $model->config = $config;
            $model->layout = $layout;
            
//            if(is_array($parts) && $this->isJson($config) && $this->isJson($layout) && $model->save()) {
            if($this->isJson($config) && $this->isJson($layout) && $model->save()) {
//                $model->saveMainCsv($mainCsvData);
                /*if(!empty($model->parts)) {
                    foreach ($model->parts as $part) {
                        $part->delete();
                    }
                }
                foreach ($parts as $part) {
                    $p = new ProjectPart();
                    $p->project_id = $model->id;
                    $p->product_id = $part['id'];
                    $p->quantity = $part['qty'];
                    $p->save();
                }*/
                $ret['status'] = 'success';
                $ret['id'] = $model->id;
                $ret['userId'] = Yii::$app->user->id;
            } else {
                $errors = [];
                foreach ($model->errors as $k=>$v) {
                    $errors[] = $v[0];
                }
                $ret['status'] = 'error';
                $ret['errors'] = $errors;
            }
            echo json_encode($ret);
        } else {
            var_dump($_POST);
        }
    }
    
    
    public function actionSaveppdata()
    {
        if(
            Yii::$app->request->isAjax 
            && Yii::$app->request->post('ppid')
        ) {
            Yii::$app->session->set('permit', $_POST);
            echo json_encode(Yii::$app->request->post('ppid'));
        }
    }



    public function actionNewuser($id)
    {
        $newCookie= new \yii\web\Cookie();
        $newCookie->name='project_id';
        $newCookie->value=$id;
        $newCookie->expire = time() + 60 * 60 * 24 * 60;
        Yii::$app->getResponse()->getCookies()->add($newCookie);
        return $this->redirect('/user/registration/member-sign-up');
    }



    /**
     * Lists all ProjectSearch models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionMyProjects()
    {
        if(!Yii::$app->user->can('all') && $this->member->type == 2 && strpos($this->member->access, 'projects') === FALSE) {
            throw new ForbiddenHttpException('You are not authorized to view this page.');
        }
        
        $searchModel = new ProjectSearch();
        $openDataProvider = $searchModel->searchOpen(Yii::$app->request->queryParams);
        $closeDataProvider = $searchModel->searchClosed(Yii::$app->request->queryParams);

        return $this->render('projects-list', [
            'searchModel' => $searchModel,
            'openDataProvider' => $openDataProvider,
            'closeDataProvider' => $closeDataProvider,
            'member' => $this->member
        ]);
    }


    /**
     * Lists all ProjectSearch models.
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionMyProjectsGrid()
    {
        if(!Yii::$app->user->can('all') && $this->member->type == 2 && strpos($this->member->access, 'projects') === FALSE) {
            throw new ForbiddenHttpException('You are not authorized to view this page.');
        }
        
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('projects-grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'member' => $this->member
        ]);
    }
    
    
    /**
     * Lists all ProjectSearch models.
     * @return mixed
     */
    public function actionProjects()
    {
        $model = Project::find()->select(['id', 'name'])->where(['company_id' => $this->member->company_id])->orderBy('id desc')->limit(8)->all();
        
        Yii::$app->response->format = 'json';
        
        return $model;
    }



    /**
     * @param $alias
     * @return array
     */
    public function actionGet($alias)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($alias == 'list' && isset ($_GET['type'])) {
            $t = addslashes(strip_tags($_GET['type']));
            $data = [];
            $powerFilter = false;
            $ppdFilter = false;
            $frameColor = false;
            $manufacturers = [];
            $colors = [];
            $cellTechs = [];
            $cid = 1;
            if($this->member) {
                $userType = $this->member->company->package_id == 3 ? 'elite' : 'pro';
            } else {
                $userType = 'pro';
            }
            if($t == 'module') {
                $models = Product::find()->where(['category_id'=>1])->andWhere(['shared_compatible'=>'1'])->active()->all();
            } elseif($t == 'inverter' && isset ($_GET['itype'])) {
                $itype = $_GET['itype'];
                if ($itype == 'micro') {
                    $models = Product::find()->where(['sub_category_id' => 2])->andWhere(['shared_compatible' => '1'])->active()->all();
                } elseif ($itype == 'string') {
                    $models = Product::find()->where(['sub_category_id' => 4])->andWhere(['shared_compatible' => '1'])->active()->all();
                } elseif ($itype == 'optimizer') {
                    $models = Product::find()->where(['sub_category_id' => 5])->andWhere(['shared_compatible' => '1'])->active()->all();
                }
            } elseif($t == 'ra') {
                $models = Product::find()->where(['is_roof_attachment'=>1])->active()->all();
            } elseif($t == 'pp') {
                $models = Product::find()->where(['category_id'=>6])->andWhere(['shared_compatible'=>'1'])->active()->all();
            }

            if(!empty($models)) {
                if($models[0]->category_id == 1 || $models[0]->category_id == 2) {
                    $powerFilter = true;
                    $ppdFilter = true;
                }
                if($models[0]->category_id == 1  || $models[0]->category_id == 3) {
                    $frameColor = true;
                }
            }

            foreach($models as $model) {
                $prs = [];
                $priceMin = 0;
                $priceMax = 0;
                if($model->manufacturer) {
                    if(isset($manufacturers[$model->manufacturer->id])) {
                        $manufacturers[$model->manufacturer->id]['count']++;
                    } else {
                        $manufacturers[$model->manufacturer->id] = ['name' => $model->manufacturer->name, 'featured'=>$model->manufacturer->featured, 'count'=>1, 'id'=>$model->manufacturer->id];
                    }
                }
                if($frameColor && strlen($model->meta->frame_color) > 1) {
                    if(isset($colors[$model->meta->frame_color])) {
                        $colors[$model->meta->frame_color]['count']++;
                    } else {
                        $colors[$model->meta->frame_color] = ['count'=>1, 'id'=>$cid, 'name'=>$model->meta->frame_color];
                        $cid++;
                    }
                }
                if($model->meta->cell) {
                    if(isset($cellTechs[$model->meta->cell->id])) {
                        $cellTechs[$model->meta->cell->id]['count']++;
                    } else {
                        $cellTechs[$model->meta->cell->id] = ['count'=>1, 'id'=>$model->meta->cell->id, 'name' => $model->meta->cell->name];
                    }
                }
                if($powerFilter === false && $model->meta->rated_power) {
                    $powerFilter = true;
                    $ppdFilter = true;
                }
                foreach ($model->prices as $price) {
                    $pr = $price->showPrice('pro', $model->on_sale, FALSE);
                    if($priceMax === 0) {
                        $priceMax = $pr;
                    }
                    if($priceMin === 0 || $pr < $priceMin) {
                        $priceMin = $pr;
                    }
                    $prs[] = [
                        'min' => $price->min,
                        'max' => $price->max,
                        'price' => $price->price,
                        'sale_price' => $price->sale_price
                    ];
                    /*
                    $pp = $price->showPrice('pro', $model->on_sale, FALSE);
                    $ep = $price->showPrice('elite', $model->on_sale, FALSE);
                    if($userType == 'pro') {
                        $pr = $pp;
                    } else {
                        $pr = $ep;
                    }
                    if($priceMax === 0) {
                        $priceMax = $pr;
                    }
                    if($priceMin === 0 || $pr < $priceMin) {
                        $priceMin = $pr;
                    }
                    $prs[] = [
                        'min' => $price->min,
                        'max' => $price->max,
                        'pro_price' => $pp,
                        'elite_price' => $ep,
                    ];*/
                }
                
                $data[] = [
                    'id' => $model->id,
                    'name' => $model->name,
                    'features' => \app\helpers\PHelper::s($model->features, 250),
                    'model' => $model->manufacturer_product_code,
                    'rating' => $model->rating,
                    'manufacturer_id' => $model->manufacturer_id,
                    'manufacturer_name' => $model->manufacturer ? $model->manufacturer->name : '',
                    'code' => $model->manufacturer_product_code,
                    'rated_power' => $model->meta->rated_power,
                    'length' => $model->meta->length,
                    'width' => $model->meta->width,
                    'height' => $model->meta->height,
                    'cell_tech_id' => $model->meta->cell_technology_id,
                    'frame_color' => strlen($model->meta->frame_color) > 1 && !empty($colors) ? $colors[$model->meta->frame_color]['id'] : '',
                    'prices' => $prs,
                    'on_sale' => $model->on_sale,
                    'priceMin' => $priceMin,
                    'priceMax' => $priceMax,
                    'count' => $model->minimum_order,
                    'minimum' => $model->minimum_order,
                    'free_shipping' => $model->free_shipping,
                    'need_shipping' => $model->need_shipping,
                    'order' => $model->order,
                    'image' => $model->thumbImage('small')
                ];
            }
            ksort($manufacturers);

            return [
                'products' => $data,
                'manufacturers' => $manufacturers,
                'colors' => $colors,
                'powerFilter' => $powerFilter,
                'ppdFilter' => $ppdFilter,
                'priceFilter' => !Yii::$app->user->isGuest,
                'cellTechs' => $cellTechs
            ];
        } elseif($alias == 'parts') {
            return Accessory::listForNewTool();
        } elseif($alias == 'project' && isset ($_GET['id']) && $_GET['id'] > 0) {
            $model = $this->findModel($_GET['id']);
            return [
                'config'=> json_decode($model->config),
                'layouts'=> json_decode($model->layout),
            ];
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
        $model = $this->findModel($id);
        if($model->order) {
            Yii::$app->session->setFlash('error', 'You cannot delete this project, it is connected to an existing order.');
            return $this->redirect(['my-projects-grid']);
        }
        foreach ($model->parts as $part) {
            $part->delete();
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted the Project');
        return $this->redirect(['my-projects-grid']);
    }

    /**
     * Checks is given string is valid or not
     * @param $string
     * @return boolean
     * @internal param int $id
     */
    protected function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function actionAddress()
    {
        echo '<pre>';
        print_r(Yii::$app->request->post());
        exit;
    }
    /**
     * Finds the page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            if($model->created_by != Yii::$app->user->id && !Yii::$app->user->can('all')) {
                throw new NotFoundHttpException('You are not authorized to access this page.');
            } 
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
