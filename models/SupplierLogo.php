<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier_logo".
 *
 * @property integer $id
 * @property string $link
 * @property string $title
 * @property integer $status
 */
class SupplierLogo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier_logo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['link', 'title'], 'string', 'max' => 255]
        ];
    }

    public function behaviors()
    {
        return [
            'image' => [
                'class' => \zxbodya\yii2\imageAttachment\ImageAttachmentBehavior::className(),
                // type name for model
                'type' => 'post',
                // image dimmentions for preview in widget 
                'previewHeight' => 100,
                'previewWidth' => 150,
                // extension for images saving
                'extension' => 'png',
                // path to location where to save images
                'directory' => Yii::getAlias('@webroot') . '/images/logos',
                'url' => Yii::getAlias('@web') . '/images/logos',
                'versions' => [
                    'small' => function ($img) {
                        /** @var ImageInterface $img */
                        return $img
                            ->copy()
                            ->resize($img->getSize()->widen(24));
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
            'link' => 'Link',
            'title' => 'Title',
            'status' => 'Status',
        ];
    }
    public static function listAll()
    {
        return self::find()->where(['status'=>1])->all();
    }
}
