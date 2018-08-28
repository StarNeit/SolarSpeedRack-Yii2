<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $company_id
 * @property string $requested_categories
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property SupplierCategory[] $supplierCategories
 */
class Supplier extends \yii\db\ActiveRecord
{
    public $requests = [];
    
    public $accessArr = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'company_id'], 'required'],
            [['user_id', 'type', 'company_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['requested_categories'], 'string', 'max' => 255],
            [['requests', 'access', 'accessArr'], 'safe']
        ];
    }

    public function afterFind() {
        parent::afterFind();
        $this->accessArr = explode(';', trim($this->access, ';'));
    }
    public function beforeSave($insert) {
        $this->access = ';' . implode(';', $this->accessArr) . ';';
        parent::beforeSave($insert);
        return true;
    }
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            [
                'class'=> \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => false
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'company_id' => 'Company ID',
            'requested_categories' => 'Requested Categories',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(SupplierCompany::className(), ['id' => 'company_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
