<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $zip_code
 * @property string $total_watt
 * @property string $total_material
 * @property string $cost_per_watt
 * @property string $cost_per_panel
 * @property string $layout
 * @property string $config
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property MCompany $company
 * @property ProjectPart[] $projectParts
 */
class Project extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
//            [['name'], 'unique'],
            [['layout', 'config'], 'string'],
            [['name', 'total_watt', 'total_material', 'cost_per_watt', 'cost_per_panel'], 'string', 'max' => 100],
            [['zip_code'], 'string', 'max' => 6]
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
            'zip_code' => 'Zip Code',
            'total_watt' => 'Total Watt',
            'total_material' => 'Total Material',
            'cost_per_watt' => 'Cost Per Watt',
            'cost_per_panel' => 'Cost Per Panel',
            'layout' => 'Layout',
            'config' => 'Config',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function saveMainCsv($csvData) 
    {
        $out = fopen($this->getCsv(null, TRUE), 'w');
        
        foreach ($csvData as $a=>$c) {
            fputcsv($out, $c);
        }
        fclose($out);
    }
    public function saveCsv($csvData) 
    {
        $app = Yii::getAlias('@app');
        if(file_exists($this->getCsv(1))) unlink($this->getCsv(1));
        if(file_exists($this->getCsv(2))) unlink($this->getCsv(2));
        if(file_exists($this->getCsv(3))) unlink($this->getCsv(3));
        $i = 1;
        foreach ($csvData as $csv) {
            $out = fopen($this->getCsv($i), 'w');
            foreach ($csv as $c) {
                fputcsv($out, $c);
            }
            fclose($out);
            exec($app . '\dxf\SSRcsv2dxf.exe ' . $this->getCsv($i) . ' ' . $this->getDXF($i));
            $i++;
        }
        return true;
    }
    protected function getCsv($id = null, $main = FALSE)
    {
        if($main)
            return Yii::getAlias('@webroot') . '/files/csv/project-' . $this->id . '.csv';
        else 
            return Yii::getAlias('@webroot') . '/files/csv/project-' . $this->id . '-' . $id . '.csv';
    }
    
    protected function getDXF($id)
    {
        return Yii::getAlias('@webroot') . '/files/dxf/project-' . $this->id . '-' . $id . '.DXF';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZip()
    {
        return $this->hasOne(ZipCode::className(), ['code' => 'zip_code']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['project_id' => 'id']);
    }
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getParts()
   {
       return $this->hasMany(ProjectPart::className(), ['project_id' => 'id']);
   }
}
