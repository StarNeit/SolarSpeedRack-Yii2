<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "s_company".
*
* @property integer $id
* @property string $name
* @property string $email 
* @property integer $created_by
* @property integer $updated_by
* @property integer $created_at
* @property integer $updated_at
* @property integer $status
*
* @property Product[] $products 
* @property PurchaseOrder[] $purchaseOrders 
* @property SAddress[] $sAddresses
* @property User $createdBy
* @property User $updatedBy
* @property ScompanyCategory[] $scompanyCategories 
*/
class SupplierCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
            'logo' => [
                'class' => \zxbodya\yii2\imageAttachment\ImageAttachmentBehavior::className(),
                // type name for model
                'type' => 'post',
                // image dimmentions for preview in widget 
                'previewHeight' => 100,
                'previewWidth' => 150,
                // extension for images saving
                'extension' => 'png',
                // path to location where to save images
                'directory' => Yii::getAlias('@webroot') . '/images/supplier-companies',
                'url' => Yii::getAlias('@web') . '/images/supplier-companies',
                'versions' => [
                    'small' => function ($img) {
                        /** @var ImageInterface $img */
                        return $img
                            ->copy()
                            ->resize($img->getSize()->widen(100));
                    },
                    'medium' => function ($img) {
                        /** @var ImageInterface $img */
                        $dstSize = $img->getSize();
                        $maxWidth = 500;
                        if ($dstSize->getWidth() > $maxWidth) {
                            $dstSize = $dstSize->widen($maxWidth);
                        }
                        return $img
                            ->copy()
                            ->resize($dstSize);
                    },
                    'original' => function ($img) {
                        /** @var ImageInterface $img */
                        $dstSize = $img->getSize();
                        return $img
                            ->copy()
                            ->resize($dstSize);
                    },
                ]
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
            'email' => 'Email', 
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(SupplierAddress::className(), ['company_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(SupplierAddress::className(), ['company_id' => 'id'])->where(['is_default'=>1]);
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
    public function getCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])->viaTable('scompany_category', ['scompany_id' => 'id']);
    }
    
    public static function listAll()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->where(['<', 'status',3])->all(), 'id', 'name');
    }
}
