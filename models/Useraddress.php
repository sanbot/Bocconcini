<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbluseraddress".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $municipalityid
 * @property string $alias
 * @property string $address
 * @property string $commentary
 * @property string $district
 *
 * @property Tblmunicipality $municipality
 * @property Tbluser $user
 */
class Useraddress extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tbluseraddress';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['userid', 'municipalityid', 'alias', 'address', 'district'], 'required'],
            [['userid', 'municipalityid'], 'integer'],
            [['alias', 'district'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 200],
            [['commentary'], 'string', 'max' => 500],
            [['municipalityid'], 'exist', 'skipOnError' => true, 'targetClass' => Municipality::className(), 'targetAttribute' => ['municipalityid' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'userid' => 'Usuario',
            'municipalityid' => 'Municipio',
            'alias' => 'Alias',
            'address' => 'Dirección',
            'commentary' => 'Comentario Adicional',
            'district' => 'Barrio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipality() {
        return $this->hasOne(Municipality::className(), ['id' => 'municipalityid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }

}
