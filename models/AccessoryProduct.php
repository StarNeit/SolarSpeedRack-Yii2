<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accessory_product".
 *
 * @property integer $id
 * @property integer $accessory_id
 * @property integer $product_id
 * @property string $name
 * @property integer $status
 *
 * @property Accessory $accessory
 * @property Product $product
 */
class AccessoryProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accessory_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accessory_id', 'product_id', 'name'], 'required'],
            [['accessory_id', 'product_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['accessory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Accessory::className(), 'targetAttribute' => ['accessory_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'accessory_id' => 'Accessory',
            'product_id' => 'Product',
            'name' => 'Color',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessory()
    {
        return $this->hasOne(Accessory::className(), ['id' => 'accessory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
