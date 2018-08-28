<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_address".
 *
 * @property integer $id
 * @property integer $is_default
 * @property integer $company_id
 * @property string $first_name
 * @property string $last_name
 * @property string $address1
 * @property string $address2
 * @property string $office_number
 * @property string $contact_number
 * @property string $city
 * @property string $state
 * @property integer $zip_code
 * @property string $country
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property SCompany $company
 * @property User $createdBy
 * @property User $updatedBy
 */
class SupplierAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_default', 'company_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['company_id'], 'required'],
            [['first_name'], 'string', 'max' => 150],
            [['last_name', 'country'], 'string', 'max' => 100],
            [['address1', 'address2', 'city'], 'string', 'max' => 255],
            [['office_number', 'contact_number'], 'string', 'max' => 20],
            [['zip_code'], 'string', 'max' => 6],
            [['state'], 'string', 'max' => 50]
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
            'is_default' => 'Is Default',
            'company_id' => 'Company ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'office_number' => 'Office Number',
            'contact_number' => 'Contact Number',
            'city' => 'City',
            'state' => 'State',
            'zip_code' => 'Zip Code',
            'country' => 'Country',
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
    public function getCompany()
    {
        return $this->hasOne(SupplierCompany::className(), ['id' => 'company_id']);
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
