<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 *
 * @property Product[] $products
 * @property SupplierCategory[] $supplierCategories
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'=>SluggableBehavior::className(),
                'attribute' => 'name'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubs()
    {
        return $this->hasMany(ProductSubCategory::className(), ['category_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getSupplierCategories()
//    {
//        return $this->hasMany(SupplierCategory::className(), ['category_id' => 'id']);
//    }
    
    public static function listAll()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
    
    public static function getAll()
    {
        $array = self::find()->all();
        $result = [];
        foreach ($array as $element) {
            $result[$element->name] = $element->name;
        }
        return $result;
    }

    public static function obtainIdBySlug($slug){
        $model = ProductCategory::find()->where(['slug' => $slug])->one();

        return $model->id;
    }

}
