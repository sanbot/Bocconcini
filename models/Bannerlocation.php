<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblbannerlocation".
 *
 * @property integer $id
 * @property string $location
 *
 * @property Tblbanner $tblbanner
 */
class Bannerlocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblbannerlocation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'location' => 'Ubicación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::className(), ['id' => 'id']);
    }
}
