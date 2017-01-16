<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbldiscount".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $percent
 * @property string $initialdate
 * @property string $finaldate
 *
 * @property Tbldiscountproduct[] $tbldiscountproducts
 */
class Discount extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tbldiscount';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description', 'percent', 'initialdate', 'finaldate'], 'required'],
            [['percent'], 'integer'],
            [['initialdate', 'finaldate'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 300],
            ['initialdate', 'compare', 'compareAttribute' => 'finaldate', 'operator' => '<', 'message' => 'Fecha inicial debe ser menor a Fecha final.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'name' => 'Descuento',
            'description' => 'Descripción',
            'percent' => 'Porcentaje',
            'initialdate' => 'Fecha inicial',
            'finaldate' => 'Fecha final',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscountproducts() {
        return $this->hasMany(Discountproduct::className(), ['discountid' => 'id']);
    }

}
