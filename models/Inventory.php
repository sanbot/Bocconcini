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

    public $excelFile;
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
            [['excelFile'], 'file', 'extensions' => 'xlsx'],
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
            'excelFile' => 'Inventario Excel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productid']);
    }
    
    public function upload() {
        $this->excelFile->saveAs('uploads/inventory/BocconciniInventory.' . $this->excelFile->extension);
        return 'uploads/inventory/BocconciniInventory.' . $this->excelFile->extension;
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
    
    public function getInventory(){
        return Product::find()
                ->select('tblproduct.id, tblproduct.name, tblinventory.quantity, tblproduct.cost, tblproduct.price, tblinventory.observation')
                ->join('LEFT JOIN', 'tblinventory', 'tblinventory.productid = tblproduct.id')
                ->asArray()
                ->all();
    }
}
