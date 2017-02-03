<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblinventory".
 *
 * @property integer $id
 * @property integer $productid
 * @property integer $quantity
 * @property string $observation
 *
 * @property Tblproduct $product
 */
class Inventory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblinventory';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['productid'], 'required'],
            [['productid', 'quantity'], 'integer'],
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
            'observation' => 'Observación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productid']);
    }

    public function findModelInventory($id){
        return Inventory::find()
                ->joinWith(['product'])
                ->where(['tblinventory.id' => $id])
                ->one();
    }
    
    public function findModelByProduct($id){
        return Inventory::find()
                ->where(['tblinventory.productid' => $id])
                ->one();
    }
}
