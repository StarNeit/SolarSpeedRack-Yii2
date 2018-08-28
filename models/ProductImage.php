<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $extension
 * @property string $file_name
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 * @property User $createdBy
 * @property User $updatedBy
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['file_name'], 'required'],
            [['extension', 'file_name'], 'string', 'max' => 250]
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
            'product_id' => 'Product ID',
            'extension' => 'Extension',
            'file_name' => 'File Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
    }

    public function saveImage($file)
    {
        $path = $this->getPath();
        $file->saveAs($path);
        $img = $img2 = Image::getImagine()->open($path);
        $img->copy()->resize($img->getSize()->widen(150))->save($this->getPath('small'));
        
        $img2->copy()->resize($img->getSize()->widen(300))->save($this->getPath('medium'));
         
    }
    
    public function copyImage($url)
    {
        $path = $this->getPath();
        copy($url, $path);
        
        $img = $img2 = Image::getImagine()->open($path);
        $img->copy()->resize($img->getSize()->widen(150))->save($this->getPath('small'));
        
        $img2->copy()->resize($img->getSize()->widen(300))->save($this->getPath('medium'));
    }
    public function renameImage($url)
    {
        $path = $this->getPath();
        rename($url, $path);
        
        $img = $img2 = Image::getImagine()->open($path);
        $img->copy()->resize($img->getSize()->widen(150))->save($this->getPath('small'));
        
        $img2->copy()->resize($img->getSize()->widen(300))->save($this->getPath('medium'));
    }
    
    public function getPath($version=NULL, $type = 'path')
    {
        $folder = '/uploads/images/';
        if($version !== NULL){
            $folder .= $version . '/';
        }
            
        if($type == 'path') {
            $folder = \Yii::getAlias('@webroot') . $folder;
        }
        return $folder . $this->id . '-' . $this->created_by . '.' . $this->extension;        
    }

    public function beforeDelete()
    {
        $this->removeImage();
        return true;
    }
    /**
     * Removes all images attached to model using this behavior
     *
     * @param null $ext
     */
    public function removeImage()
    {
        if (file_exists($this->getPath())) {
            @unlink($this->getPath());
        }
        if (file_exists($this->getPath('small'))) {
            @unlink($this->getPath('small'));
        }
        if (file_exists($this->getPath('medium'))) {
            @unlink($this->getPath('medium'));
        }
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
}
