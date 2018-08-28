<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $note
 * @property string $features
 * @property string $specifications
 * @property string $videos
 * @property string $downloads
 * @property string $estimated_handling_time
 * @property integer $minimum_order
 * @property integer $manufacturer_id
 * @property string $manufacturer_product_code
 * @property string $code
 * @property integer $shared_compatible
 * @property integer $standard_compatible
 * @property string $msrp
 * @property integer $on_sale
 * @property integer $sale_price
 * @property string $sale_start
 * @property string $sale_end
 * @property string $nmfc
 * @property string $package_type
 * @property integer $category_id
 * @property integer $sub_category_id
 * @property integer $is_inverter
 * @property integer $is_roof_attachment
 * @property integer $calculate_per_foot
 * @property integer $free_shipping
 * @property integer $need_shipping
 * @property integer $need_tax
 * @property string $pdf
 * @property string $pdf2
 * @property string $pdf3
 * @property string $cad
 * @property string $youtube
 * @property string $rating
 * @property string $class
 * @property integer $hazardous
 * @property string $commodity_type
 * @property string $content_type
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $handling_id
 * @property integer $order
 * @property integer $available_stock
 *
 * @property OrderProduct[] $orderProducts
 * @property PoProduct[] $poProducts
 * @property Price[] $prices
 * @property ProductCategory $category
 * @property User $createdBy
 * @property HandlingConfig $handling
 * @property Manufacturer $manufacturer
 * @property SCompany $company
 * @property User $updatedBy
 * @property ProductImage[] $productImages
 * @property ProductMetadata[] $meta
 * @property Review[] $reviews
 */
class Product extends \yii\db\ActiveRecord
{
    public $pdfFile;
    public $pdfFile2;
    public $pdfFile3;
    public $cadFile;
    public $imageFiles;
    
    
    public $utype;
    public $quantity;
    
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_BANNED = 3;
    

    public static function statusOption($op = null) 
    {
        if($op === null) {
            return [
                self::STATUS_ACTIVE => 'Active',
                self::STATUS_INACTIVE => 'Inactive',
                self::STATUS_BANNED => 'Banned',
            ];
        } else {
            if($op === self::STATUS_ACTIVE) {
                return 'Active';
            } elseif($op === self::STATUS_INACTIVE) {
                return 'Inactive';
            } elseif($op === self::STATUS_BANNED) {
                return 'Banned';
            } else {
                return 'Unknown';
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'features', 'category_id', 'manufacturer_product_code'], 'required'],
            [['manufacturer_id', 'category_id', 'sub_category_id', 'minimum_order', 'hazardous', 'handling_id', 'created_by',
                'updated_by', 'created_at', 'updated_at', 'status', 'on_sale', 'free_shipping', 'need_shipping', 'need_tax', 'is_inverter',
                'is_roof_attachment', 'calculate_per_foot', 'order', 'available_stock'], 'integer'],
            [['specifications','downloads', 'videos', 'features'], 'safe'],
            [['sale_start', 'sale_end', 'package_type', 'estimated_handling_time'], 'string'],
            ['manufacturer_product_code', 'unique', 'targetAttribute' => ['manufacturer_product_code'], 'message'=>'Product key "{value}" already exists!'],
            [['name'], 'string', 'max' => 150],
            [['note'], 'string', 'max' => 255],
            [['manufacturer_product_code'], 'string', 'max' => 100],
            [['pdf', 'pdf2', 'pdf3', 'cad', 'youtube'], 'string', 'max' => 255],
            [['class'], 'string', 'max' => 6],
            [['commodity_type', 'content_type'], 'string', 'max' => 32],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 10],
            [['pdfFile'], 'file', 'extensions'=>'pdf'],
            [['cadFile'], 'file', 'extensions'=>'dwg'],
            [['youtube', 'product_link'], 'url']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className()
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'com' => 'Company',
            'name' => 'Name',
            'features' => 'Description',
            'manufacturer_product_code' => 'Product Code',
            'features' => 'Features',
            'specifications' => 'Specifications',
            'videos' => 'Videos',
            'downloads' => 'Downloads',
            'minimum_order' => 'Mininum Quantity',
            'manufacturer_id' => 'Manufacturer ID',
            'manufacturer_product_code' => 'Manufacturer Product Code',
            'code' => 'Code',
            'shared_compatible' => 'Shared Compatible',
            'standard_compatible' => 'Standard Compatible',
            'on_sale' => 'On Sale',
            'sale_end' => 'Sale end',
            'msrp' => 'MSRP',
            'nmfc' => 'Nmfc',
            'package_type' => 'Package Type',
            'category_id' => 'Category',
            'sub_category_id' => 'Sub-category',
            'handling_id' => 'Handling Configuration',
            'pdf' => 'Pdf 1',
            'pdf2' => 'Pdf 2',
            'pdf3' => 'Pdf 3',
            'cad' => 'Cad',
            'youtube' => 'Video',
            'rating' => 'Rating',
            'class' => 'FrightQuote Class',
            'hazardous' => 'Hazardous',
            'commodity_type' => 'Commodity Type',
            'content_type' => 'Content Type',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'available_stock' => 'Available Stock Quantity',
        ];
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        
        $this->pdfFile = \yii\web\UploadedFile::getInstance($this, 'pdfFile');
        $this->pdfFile2 = \yii\web\UploadedFile::getInstance($this, 'pdfFile2');
        $this->pdfFile3 = \yii\web\UploadedFile::getInstance($this, 'pdfFile3');
        $this->cadFile = \yii\web\UploadedFile::getInstance($this, 'cadFile');
        $this->imageFiles = \yii\web\UploadedFile::getInstances($this, 'imageFiles');
        
        if($this->pdfFile) {
            $this->pdf = $this->pdfFile->baseName . '.' . $this->pdfFile->extension;
        }
        if($this->pdfFile2) {
            $this->pdf2 = $this->pdfFile2->baseName . '.' . $this->pdfFile2->extension;
        }
        if($this->pdfFile3) {
            $this->pdf3 = $this->pdfFile3->baseName . '.' . $this->pdfFile3->extension;
        }
        if($this->cadFile ) {
            $this->cad = $this->cadFile->baseName . '.' . $this->cadFile->extension;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->saveImages();
        if($this->pdfFile) {
            $this->pdfFile->saveAs($this->getFile('pdf'));
        }
        if($this->pdfFile2) {
            $this->pdfFile2->saveAs($this->getFile('pdf', 2));
        }
        if($this->pdfFile3) {
            $this->pdfFile3->saveAs($this->getFile('pdf', 3));
        }
        if($this->cadFile) {
            $this->cadFile->saveAs($this->getFile('cad'));
        }
        
        parent::afterSave($insert, $changedAttributes);
    }
    
    public function beforeDelete()
    {
        if (file_exists($this->getFile('pdf'))) {
            @unlink($this->getFile('pdf'));
        }
        if (file_exists($this->getFile('pdf', 2))) {
            @unlink($this->getFile('pdf', 2));
        }
        if (file_exists($this->getFile('pdf', 3))) {
            @unlink($this->getFile('pdf', 3));
        }
        if (file_exists($this->getFile('cad'))) {
            @unlink($this->getFile('cad'));
        }
        return true;
    }
    public function getFile($type, $no=null)
    {
        return  \Yii::getAlias('@webroot') . $this->getFileUrl($type, $no);
    }
    public function getFileUrl($type, $no=null)
    {
        if($no === null) {
            return  '/uploads/' . $type . '/' . $this->id . '-' . $this->$type;
        } else {
            $name = $type . $no;
            return  '/uploads/' . $type . '/' . $this->id . '-' . $no . '-' . $this->$name;
        }
    }
    
    public function saveImages()
    {
        if(!empty($this->imageFiles)) {
            foreach ($this->imageFiles as $file) {
                $img = new ProductImage();
                $img->product_id = $this->id;
                $img->extension = $file->extension;
                $img->file_name = $file->baseName . '.' . $file->extension;
                if($img->save()) {
                    $img->saveImage($file);
                }
            }
        }
    }
    public static function elitePrice($price, $decimal = true) {
        if($decimal) {
           return Yii::$app->formatter->asDecimal($price + $price * .05, 2);
        } else {
            return round($price + $price * .05, 2);
        }
    }
    public static function proPrice($price, $decimal = true) {
        if($decimal) {
            return Yii::$app->formatter->asDecimal($price + $price * .08, 2);
        } else {
            return round($price + $price * .08, 2);
        }
    }
    
    public function price($for, $qty = 1, $minimum = null, $force = false)
    {
        $price = Price::find()->where(['product_id'=>  $this->id])->andWhere(['<=', 'min', $qty])->andWhere(['or', 'max>=' . $qty, "max='0'"])->one();
        if($price) {
            if($minimum) {
                if($force === true) {
                    return $price->showPrice($for, $this->on_sale, false);
                } else {
                    return $price->showPrice($for, $this->on_sale);
                }
            } else {
                return round($price->showPrice($for, $this->on_sale, FALSE) * $qty, 2);
            }
        } else {
            return '0';
        }
    }
    public function vendorPrice($qty = 1)
    {
        $price = Price::find()->where(['product_id'=>  $this->id])->andWhere(['<=', 'min', $qty])->andWhere(['or', 'max>=' . $qty, "max='0'"])->one();
        if($price) {
            if($price->product->on_sale) {
                return $price->sale_price;
            } else {
                return $price->price;
            }
        } else {
            return '0';
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['product_id' => 'id']);
    }
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['product_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }
    public function getSubcategory()
    {
        return $this->hasOne(ProductSubCategory::className(), ['id' => 'sub_category_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHandling()
    {
        return $this->hasOne(HandlingConfig::className(), ['id' => 'handling_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['product_id' => 'id']);
    }
    
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getManufacturer() 
    { 
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer_id']); 
    } 
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getMeta()
    { 
        return $this->hasOne(ProductMetadata::className(), ['product_id' => 'id']); 
    } 
    
    
    public static function listCommodity()
    {
        return [
            'GeneralMerchandise' => 'General Merchandise',
            'Machinery' => 'Machinery',
            'HouseholdGoods' => 'Household Goods',
            'FragileGoods' => 'Fragile Goods',
            'ComputerHardware' => 'Computer Hardware',
            'BottledProducts' => 'Bottled Products',
            'BottleBeverages' => 'Bottle Beverages',
            'NonPerishableFood' => 'Non Perishable Food',
            'SteelSheet' => 'Steel Sheet',
            'BrandedGoods' => 'Branded Goods',
            'PrecisionInstruments' => 'Precision Instruments',
            'ChemicalsHazardous' => 'Chemicals Hazardous',
            'FineArt' => 'Fine Art',
            'Automobiles' => 'Automobiles',
            'CellPhones' => 'Cell Phones',
            'NewMachinery' => 'New Machinery',
            'UsedMachinery' => 'Used Machinery',
            'HotTubs' => 'Hot Tubs'
        ];
    }
    public function carouselImages($version)
    {
        $imgs = [];    
        foreach ($this->images as $image) {
            $imgs[] = \yii\helpers\Html::img($image->getPath($version, 'url'), ['class'=>'img-responsize img-thumbnail']);
        }
        return $imgs;
    }
    public function thumbImage($version)
    {
        $img = '';
        if(isset($this->images[0])) {
            $img = $this->images[0]->getPath($version, 'url');
        }
        return $img;
    }

    public static function listContents()
    {
        return [
            'NewCommercialGoods' => 'New Commercial Goods',
            'UsedCommercialGoods' => 'Used Commercial Goods',
            'HouseholdGoods' => 'Household Goods',
            'FragileGoods' => 'Fragile Goods',
            'Automobile' => 'Automobile',
            'Motorcycle' => 'Motorcycle',
            'AutoOrMotorcycle' => 'Auto or Motorcycle'
        ];    
    }
    public static function listPackageType()
    {
        return [
            'Pallets_48x40' => 'Pallets 48x40',
            'Pallets_48x48' => 'Pallets 48x48',
            'Pallets_60x48' => 'Pallets 60x48',
            'Pallets_120x80' => 'Pallets 120x80',
            'Pallets_120x100' => 'Pallets 120x100',
            'Pallets_120x120' => 'Pallets 120x120',
            'Pallets_other' => 'Pallets Other',
            'Boxes' => 'Boxes',
            'Bales' => 'Bales',
            'Bundles' => 'Bundles',
            'Coils' => 'Coils',
            'Crates' => 'Crates',
            'Cylinders' => 'Cylinders',
            'Drums' => 'Drums',
            'Pails' => 'Pails',
            'Reels' => 'Reels',
            'Rolls' => 'Rolls',
            'TubesPipes' => 'TubesPipes',
            'ATV' => 'ATV',
            'Cylinders' => 'Cylinders',
            'Slipsheets' => 'Slipsheets',
            'Unit' => 'Unit',
            'Unknown' => 'Unknown'
        ];    
    }
    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
    
    public function addReview($review)
    {
        $tot = count($this->reviews);
        $this->rating = (($tot - 1) * $this->rating + $review->rating ) / $tot;
        $this->save();
    }
    public function getReviewsLog()
    {
        $ret = [5=>0,4=>0,3=>0,2=>0,1=>0];
        foreach ($this->reviews as $rev) {
            $ret[intval($rev->rating)]++;
        }
        return $ret;
    }
    public static function listAll()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
    
}
