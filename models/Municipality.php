<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblmunicipality".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Tbluseraddress[] $tbluseraddresses
 */
class Municipality extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblmunicipality';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'name' => 'Municipio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUseraddresses() {
        return $this->hasMany(Useraddress::className(), ['municipalityid' => 'id']);
    }

}
