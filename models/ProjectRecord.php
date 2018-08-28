<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_record".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $status
 * @property string $notes_customer
 * @property integer $created_at
 *
 * @property ProjectActivity[] $projectActivities
 */
class ProjectRecord extends \yii\db\ActiveRecord
{
    const DELETED = 0;
    const ACTIVE = 1;
    const SAVED = 2;

    public static $status = ['Deleted', 'Active', 'Saved'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'created_at'], 'required'],
            [['project_id', 'status', 'created_at'], 'integer'],
            [['notes_customer'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'status' => 'Status',
            'notes_customer' => 'notes_customer',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectActivities()
    {
        return $this->hasMany(ProjectActivity::className(), ['project_rec_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectActivitiesInstaller()
    {
        return $this->hasMany(ProjectActivity::className(), ['project_rec_id' => 'id'])
            ->joinWith('activityListInstaller');
    }
}
