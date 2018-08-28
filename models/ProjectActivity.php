<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project_activity".
 *
 * @property integer $id
 * @property integer $project_rec_id
 * @property string $activity_id
 * @property integer $completed
 * @property integer $done_percent
 * @property string $notes_customer
 * @property string $document
 * @property integer $status
 * @property integer $updated_at
 *
 * @property ProjectRecord $projectRec
 */
class ProjectActivity extends \yii\db\ActiveRecord
{
    const INSPECTION_DEFAULT = 1;
    const INSPECTION_WAIT_INSTALLER = 2;
    const INSPECTION_WAIT_MEMBER = 3;
    const INSPECTION_APROVED = 4;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_rec_id', 'activity_id', 'updated_at'], 'required'],
            [['project_rec_id', 'completed', 'done_percent', 'status', 'updated_at'], 'integer'],
            [['notes_customer', 'document'], 'string', 'max' => 255],
            [['project_rec_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectRecord::className(), 'targetAttribute' => ['project_rec_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_rec_id' => 'Project Rec ID',
            'activity_id' => 'Activity ID',
            'completed' => 'Completed',
            'done_percent' => 'Done Percent',
            'notes_customer' => 'notes_customer',
            'document' => 'Document',
            'status' => 'Status',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectRec()
    {
        return $this->hasOne(ProjectRecord::className(), ['id' => 'project_rec_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityList()
    {
        return $this->hasOne(ProjectActivityList::className(), ['id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityListInstaller()
    {
        return $this->hasOne(ProjectActivityList::className(), ['id' => 'activity_id'])->where(['type' => ProjectActivityList::TYPE_INSTALLER]);
    }

    /**
     * @param $projectId
     * @param $activityId
     * @return bool|mixed
     */
    public static function obtainActivity($projectId, $activityId){

        $model = self::find()->where(['project_rec_id' => $projectId])->andWhere(['activity_id' => $activityId])->one();

        if($model)
            return $model;

        return false;
    }
}
