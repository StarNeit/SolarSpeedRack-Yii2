<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_metadata".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $weight
 * @property string $quantity_per_box
 * @property string $box_weight
 * @property string $rated_power
 * @property integer $cell_technology_id
 * @property string $frame_color
 *
 * @property Product $product
 */
class ProductMetadata extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_metadata';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'cell_technology_id', 'quantity_per_box', 'rated_power'], 'integer'],
            [['length', 'width', 'height', 'weight', 'box_weight'], 'number'],
            [['frame_color'], 'string', 'max' => 50]
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
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'weight' => 'Weight',
            'quantity_per_box' => 'Quantity Per Box',
            'box_weight' => 'Box Weight',
            'rated_power' => 'Rated Power',
            'cell_technology_id' => 'Cell Technology ID',
            'frame_color' => 'Product Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCell()
    {
        return $this->hasOne(CellTech::className(), ['id' => 'cell_technology_id']);
    }
}
