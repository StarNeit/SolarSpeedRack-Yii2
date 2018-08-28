<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_activity_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property integer $type
 *
 * @property ProjectActivity[] $projectActivities
 */
class ProjectActivityList extends \yii\db\ActiveRecord
{

    const TYPE_INSTALLER = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_activity_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'type'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
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
            'slug' => 'Slug',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectActivities()
    {
        return $this->hasMany(ProjectActivity::className(), ['activity_id' => 'id']);
    }
}
