<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $message
 * @property string $title
 * @property string $file
 * @property integer $mark_read
 * @property integer $status
 * @property integer $type
 * @property integer $created_at
 * @property integer $activity_id
 * @property integer $project_id
 * @property integer $to_user_id
 */
class Message extends \yii\db\ActiveRecord
{

    const NOT_READ = 1;
    const READ = 2;

    const NOTIFICATION = 1;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'mark_read', 'status', 'type', 'created_at', 'activity_id', 'project_id', 'to_user_id'], 'integer'],
            [['message'], 'string'],
            [['title', 'file'], 'string', 'max' => 255],
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
            'message' => 'Message',
            'title' => 'Title',
            'file' => 'File',
            'mark_read' => 'Mark Read',
            'status' => 'Status',
            'type' => 'Type',
            'created_at' => 'Created At',
            'activity_id' => 'Activity ID',
            'project_id' => 'Project ID',
            'to_user_id' => 'To User ID',
        ];
    }

    /**
     * @return bool
     */
    public static function isUnread(){

        $model = self::find()->where(['to_user_id' => Yii::$app->user->getId()])->andWhere(['mark_read' => self::NOT_READ])->all();

        return $model ? true : false;
    }
}
