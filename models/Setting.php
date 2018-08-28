<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $target
 */
class Setting extends \yii\db\ActiveRecord
{
    
    public $get;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['value'], 'string'],
            [['target'], 'string', 'max' => 20]
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
            'value' => 'Value',
            'target' => 'Target',
        ];
    }
    public static function get($name)
    {
        $ret = self::find()->where(['name'=>$name])->asArray()->one();
        if(!empty($ret)) {
            return $ret['value'];
        } else {
            return false;
        }
    }
    public function g($name)
    {
        if(isset($this->get[$name])) {
            return $this->get[$name];
        } else {
            return '';
        }
    }
}
