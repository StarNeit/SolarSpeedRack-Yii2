<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $min
 * @property integer $max
 * @property string $price
 * @property integer $pro_percent
 * @property integer $elite_percent
 *
 * @property Product $product
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'price'], 'required'],
            [['product_id', 'min', 'max', 'pro_percent', 'elite_percent'], 'integer'],
            [['price', 'sale_price'], 'number']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'min' => 'Minimum Quantity',
            'max' => 'Maximum Quantity',
            'price' => 'Price',
            'pro_percent' => 'Pro %',
            'elite_percent' => 'Elite %',
        ];
    }

    public function showPrice($type, $on_sale = false, $decimal = true) 
    {
//        if(strlen($type) > 1) {
//            $pn = $type . '_percent';
//        } else {
//            $pn = 'pro_percent';
//        }
//        $percent = $this->$pn;
        $percent = Setting::get('global_pro_percent_value');
        if($on_sale) {
            if($decimal) {
                return Yii::$app->formatter->asDecimal($this->sale_price + $this->sale_price * ($percent / 100), 2);
            } else {
                return round($this->sale_price + $this->sale_price * ($percent / 100), 2);
            }
        } else {
            if($decimal) {
                return Yii::$app->formatter->asDecimal($this->price + ($this->price * ($percent / 100)), 2);
            } else {
                return round($this->price + $this->price * ($percent / 100), 2);
            }
        }
//        if($type == 'elite') {
//            if($on_sale) {
//                return Product::elitePrice($this->sale_price, $decimal);
//            } else {
//                return Product::elitePrice($this->price, $decimal);
//            }
//        } else {
//            if($on_sale) {
//                return Product::proPrice($this->sale_price, $decimal);
//            } else {
//                return Product::proPrice($this->price, $decimal);
//            }
//        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
