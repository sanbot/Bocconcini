<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblsales".
 *
 * @property integer $id
 * @property integer $productid
 * @property integer $quantity
 * @property string $observation
 * @property string $date
 *
 * @property Tblproduct $product
 */
class Sales extends \yii\db\ActiveRecord {

    public $enddate;
    public $startdate;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblsales';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['productid', 'quantity'], 'integer'],
            [['date', 'startdate', 'enddate'], 'safe'],
            [['observation'], 'string', 'max' => 150],
            [['productid'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'productid' => 'Producto',
            'quantity' => 'Cantidad',
            'observation' => 'Descripción de venta',
            'date' => 'Fecha',
            'enddate' => 'Fecha Final',
            'startdate' => 'Fecha Inicial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productid']);
    }

}
