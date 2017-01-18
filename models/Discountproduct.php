<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbldiscountproduct".
 *
 * @property integer $id
 * @property integer $prductid
 * @property integer $discountid
 *
 * @property Tbldiscount $discount
 * @property Tblproduct $prduct
 */
class Discountproduct extends \yii\db\ActiveRecord {

    public $value;
    public $productcategory;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tbldiscountproduct';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['prductid', 'discountid'], 'required'],
            [['prductid', 'discountid'], 'integer'],
            [['discountid'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discountid' => 'id']],
            [['prductid'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['prductid' => 'id']],
            [['value','productcategory'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'prductid' => 'Producto',
            'discountid' => 'Descuento',
            'value' => 'Precio con Descuento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount() {
        return $this->hasOne(Discount::className(), ['id' => 'discountid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'prductid']);
    }

}
