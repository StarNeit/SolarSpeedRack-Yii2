<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_details".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $customer_id
 * @property integer $installer_id
 * @property string $inspection_date
 * @property integer $inspection_time
 * @property string $inspection_detail
 * @property string $installation_date
 * @property integer $installation_time
 * @property string $installation_detail
 * @property integer $inspection_status
 * @property integer $installation_status
 * @property integer $customer_confirmation
 * @property integer $permit_plan_status
 * @property integer $products_shipped
 * @property integer $completion_form_submitted
 * @property integer $permit_plan_id
 *
 * @property User $customer
 * @property User $installer
 * @property Project $project
 */
class ProjectDetails extends \yii\db\ActiveRecord {
/**
 * @property integer ProjectDetails::INSPECTION_NOT_CONFIRMED=1
 * @property integer ProjectDetails::INSPECTION_CONFIRMED=2
 * @property integer ProjectDetails::INSPECTION_DONE=1
 */
    const INSPECTION_NOT_CONFIRMED=1;
    const INSPECTION_CONFIRMED=2;
    const INSPECTION_DONE=3;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'project_details';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['project_id', 'customer_id', 'installer_id'], 'required'],
            [['project_id', 'customer_id', 'installer_id',  'installation_status', 'inspection_status', 'customer_confirmation', 'permit_plan_status', 'products_shipped', 'completion_form_submitted', 'permit_plan_id'], 'integer'],
            [['inspection_date',  'inspection_status', 'inspection_time', 'installation_status', 'installation_date'], 'safe'],
            [['inspection_detail', 'installation_detail'], 'string'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['installer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['installer_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'installer_id' => Yii::t('app', 'Installer ID'),
            'inspection_date' => Yii::t('app', 'Inspection Date'),
            'inspection_time' => Yii::t('app', 'Inspection Time'),
            'inspection_detail' => Yii::t('app', 'Inspection Detail'),
            'installation_date' => Yii::t('app', 'Installation Date'),
            'installation_time' => Yii::t('app', 'Installation Time'),
            'installation_detail' => Yii::t('app', 'Installation Detail'),
            'inspection_status' => Yii::t('app', 'Inspection Status'),
            'installation_status' => Yii::t('app', 'Installation Status'),
            'customer_confirmation' => Yii::t('app', 'Customer Confirmation'),
            'permit_plan_status' => Yii::t('app', 'Permit Plan Status'),
            'products_shipped' => Yii::t('app', 'Products Shipped'),
            'completion_form_submitted' => Yii::t('app', 'Completion Form Submitted'),
            'permit_plan_id' => Yii::t('app', 'Permit Plan ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer() {
        return $this->hasOne(User::className(), ['id' => 'customer_id'])->with(['profile']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstaller() {
        return $this->hasOne(User::className(), ['id' => 'installer_id'])->with(['profile']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject() {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @inheritdoc
     * @return ProjectDetailsQuery the active query used by this AR class.
     */
    public static function find() {
        return new ProjectDetailsQuery(get_called_class());
    }

    
    /**
     * @return inspection_status
     */
    public function getInspectionStatus() {
        
        $status = $this->inspection_status;

        return $status == 1 ? "Not Confirmed" : ($status == 2 ? "Confirmed": "Go to Installation" );
    }
 /**
     * @return inspection_status
     */
    public function getInstallationStatus() {
        
        $status = $this->installation_status;

        return $status == 1 ? "Not Done" : ($status == 2 ? "In Progress": "Complete" );
    }
}
