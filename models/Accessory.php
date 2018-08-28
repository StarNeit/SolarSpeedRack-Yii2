<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accessory".
 *
 * @property integer $id
 * @property string $slug
 * @property string $description
 * @property integer $order
 * @property integer $status
 *
 * @property Product $product
 */
class Accessory extends \yii\db\ActiveRecord
{
    public $productsArr = [];
    public $productColors = [];
    public $existingArr = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accessory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'status'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 50]
        ];
    }

    public function beforeSave($insert) {
        foreach ($this->productsArr as $k=>$product) {
            if($product > 0) {
                if(in_array($product, $this->existingArr)) {

                } else {
                    $ap = new AccessoryProduct();
                    $ap->accessory_id = $this->id;
                    $ap->product_id = $product;
                    $ap->name = $this->productColors[$k];
                    $ap->save();
                }
            }
        }
        parent::beforeSave($insert);
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'product_1' => 'Product 1',
            'product_2' => 'Product 2',
            'order' => 'Order',
            'status' => 'Status',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public static function listForTool($type)
    {
        $all = self::find()->where(['<', 'status', 3])->orderBy('order ASC, id ASC')->with('product')->all();
        $data = [];
        foreach ($all as $a) {
            if($a->product) {
                $data[] = [
                    'slug' => $a->slug,
                    'id' => $a->product->id,
                    'code' => $a->product->manufacturer_product_code,
                    'description' => $a->product->name,
                    'price' => $a->product->price($type, $a->product->minimum_order, true)
                ];
            }
        }
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(AccessoryProduct::className(), ['accessory_id' => 'id']);
    }

    public static function listForNewTool()
    {
        $all = self::find()->where(['<', 'accessory.status', 3])->orderBy('order ASC, id ASC')->joinWith('links', 'links.product')->all();
        $data = [];
        $linkData = [];
        foreach ($all as $a) {
            if(!empty($a->links)) {
                foreach($a->links as $link) {
                    if(empty($linkData)) {
                        $linkData = [
                            'slug' => $a->slug,
                        ];
                    }
                    $linkData['colors'][] = $link->name;
                    $linkData[$link->name]['id'] = $link->product_id;
                    $linkData[$link->name]['code'] = $link->product->manufacturer_product_code;
                    $linkData[$link->name]['description'] = $link->product->name;
                    $linkData[$link->name]['on_sale'] = $link->product->on_sale;
                    $linkData[$link->name]['m_qty'] = $link->product->minimum_order;

                    if(!empty($link->product->prices)) {
                        foreach ($link->product->prices as $price) {
                            $linkData['price'][$link->name][] = [
                                'min' => $price->min,
                                'max' => $price->max,
                                'price' => $price->showPrice('pro', false, FALSE),
                                'sale_price' => $price->showPrice('pro', true, FALSE)
                            ];
                        }
                    } else {
                        $linkData['price'][$link->name][] = [
                            'min' => 1,
                            'max' => 0,
                            'price' => 0,
                            'sale_price' => 0
                        ];
                    }
                }
                $data[] = $linkData;
                $linkData = [];
            }
        }
        return $data;
    }
}
