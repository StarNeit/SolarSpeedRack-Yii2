<?php

namespace app\modules\manage\controllers;

use Yii;
use app\models\Product;
use app\modules\manage\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\scraper\HtmlScraper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionInvalid()
    {
        $cats = (new \yii\db\Query)
                        ->select(['id', 'name'])
                        ->from('product_category')
                        ->all();
        $all = [];
        foreach ($cats as $cat) {
            $all[] = [
                'cid'=>$cat['id'],
                'cname'=>$cat['name'],
                'products' => (new \yii\db\Query)
                                ->select('product_id')
                                ->from('product_metadata')
                                ->leftJoin('product', "product.id = product_metadata.product_id")
                                ->where("`length` = '0' OR `width` = '0' OR `height` = '0' OR `weight` = '0'")
                                ->andWhere("product.category_id = " . $cat['id'])
                                ->andWhere("product.status = 1")
                                ->all()
            ];
        }
        
        return $this->render('invalid', [
            'all' => $all,
        ]);
    }
    
    
    public function actionIndex()
    {        
        
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionPrice($id)
    {
        $model = $this->findModel($id);
        $newprice = new \app\models\Price();
        $newprice->product_id = $id;
        
        if ($newprice->load(Yii::$app->request->post()) && $newprice->save()) {
            Yii::$app->session->setFlash('success', 'Successfully Created.');
            $newprice = new \app\models\Price();
            $newprice->product_id = $id;
        }
        return $this->render('prices', [
            'model' => $model,
            'newprice' => $newprice
        ]);
    }
    
    public function actionUpdatePrice($id)
    {
        $model = \app\models\Price::findOne($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Successfully Updated.');
            return $this->redirect(['price', 'id' => $model->product_id]);
        }
        return $this->render('update_price', [
            'model' => $model
        ]);
    }
    public function actionDelPrice($id)
    {   
        if (($model = \app\models\Price::findOne($id)) !== null) {
            $p = $model->product_id;
            $model->delete();
            Yii::$app->session->setFlash('Successfully Deleted.');
            $this->redirect(['product/price', 'id'=>$p]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->loadDefaultValues();
        $meta = new \app\models\ProductMetadata();
        
        if ($model->load(Yii::$app->request->post()) && $model->save() && $meta->load(Yii::$app->request->post())) {
            $meta->product_id = $model->id;
            $meta->save();
            return $this->redirect(['price', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'meta' => $meta,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $meta = $model->meta;
        if ($model->load(Yii::$app->request->post()) && $model->save() && $meta->load(Yii::$app->request->post()) && $meta->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'meta' => $meta,
            ]);
        }
    }
    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelImg($id)
    {
        
        $model = \app\models\ProductImage::find()->where(['id'=>$id])->one();
        
        $product = $this->findModel($model->product_id);
        
        if($model !== null && $model->delete()) {
            Yii::$app->session->setFlash('success', 'The product image was deleted successfully.');
        }
        
        
        return $this->redirect(['update', 'id'=>$product->id]);
    }
    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelFile($id, $type, $no = NULL)
    {
        $model = $this->findModel($id);
        if (file_exists($model->getFile($type, $no))) {
            @unlink($model->getFile($type, $no));
        }
        $name = $type . $no;
        $model->$name = '';
        $model->save(false);
        Yii::$app->session->setFlash('success', 'The file was deleted successfully.');
        return $this->redirect(['update', 'id'=>$model->id]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->images as $image) {
            $image->delete();
        }
        foreach ($model->prices as $price) {
            $price->delete();
        }
        if($model->meta) {
            $model->meta->delete();
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPricecsv() 
    {
        $products = (new \yii\db\Query())
                ->from('price  p')
                ->select(["p.id", "Product Id"=>"pd.id", "pd.name", "Product Description"=>"pd.features", "Minimum Quantity"=> "p.min", "Maximum Quantity"=> "p.max", "p.price", "p.sale_price", "p.pro_percent", "p.elite_percent", "Sale End Date" => "pd.sale_end"])
                ->leftJoin('product pd', 'p.product_id = pd.id')
                ->where("pd.status =1")
                ->orderBy(['pd.id'=>SORT_ASC])
                ->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=products.csv');

        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array_keys($products[0]));
        foreach($products as $product) {
            fputcsv($output, array_values($product));
        }
    }
    public function actionUpdatePriceByCsv()
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
//                        print_r($data);             
                    if($i == 1)
                    {
                        $i++;
                    } else {
                        $model = \app\models\Price::findOne($data[0]);
                        if($model) {
                            $model->price = $data[6];
                            $model->sale_price = $data[7];
                            $model->pro_percent = $data[8];
                            $model->elite_percent = $data[9];
                            $model->save();
                        }
                        
                    }
                }
                Yii::$app->session->setFlash('success', 'Product prices were updated successfully.');
            }
        }
        return $this->render('update_csv', []);
    }
    public function actionCsv() 
    {
        $products = (new \yii\db\Query())
                ->from('product p')
                ->select(["p.id", "p.name", "Description"=>"p.features","p.free_shipping", "Brand"=>"m.name", "URL"=>'product_link', 'Category'=> "pc.name", "Sub Category"=>"ps.name", "pm.length", "pm.width", "pm.height", "pm.weight", "pm.rated_power", "pm.frame_color", "Cell Technology"=>"ct.name", "Sale End Date" => "p.sale_end"])
                ->leftJoin('product_category pc', 'p.category_id = pc.id')
                ->leftJoin('product_sub_category ps', 'ps.id = p.sub_category_id')
                ->leftJoin('product_metadata pm', 'pm.product_id = p.id')
                ->leftJoin('cell_tech ct', 'ct.id = pm.cell_technology_id')
                ->leftJoin('manufacturer m', 'm.id = p.manufacturer_id')
                ->where("p.status =1")
                ->orderBy(['p.id'=>SORT_ASC])
                ->all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=products.csv');

        $output = fopen('php://output', 'w');

        // output the column headings
        fputcsv($output, array_keys($products[0]));
        foreach($products as $product) {
            fputcsv($output, array_values($product));
        }
    }
    public function actionUpdateByCsv()
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
//                        print_r($data);             
                    if($i == 1)
                    {
                        $i++;
                    } else {
                        $model = Product::findOne($data[0]);
                        if($model) {
                            
                            
//                            $model->name = $data[1];
                            $model->free_shipping =(int) $data[3];
                            $model->save();
//                            $model->meta->length = $data[7];
//                            $model->meta->width = $data[8];
//                            $model->meta->height = $data[9];
//                            $model->meta->weight = $data[10];
//                            $model->meta->rated_power = $data[11];
//                            $model->meta->frame_color = $data[12];
                            
//                            if(strlen($data[11]) > 1) {
//                                if(!isset($cellTechs[$data[13]])) {
//                                    $ct = \app\models\CellTech::find()->where(['like', 'name', trim($data[13])])->one();
//                                    if($ct === null) {
//                                        $ct = new \app\models\CellTech();
//                                        $ct->name = $data[13];
//                                        $ct->save();
//                                    }
//                                    $cellTechs[$data[13]] = $ct->id;
//                                }
//                                $model->meta->cell_technology_id = $cellTechs[$data[13]];
//                            }
//                            $model->meta->save();
                        }
                    }
                }
            }
            Yii::$app->session->setFlash('success', 'Products were updated successfully.');
        }
        return $this->render('update_csv', [
//            'model' => $model
        ]);
    }
    
}
