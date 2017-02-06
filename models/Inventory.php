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
    public $totalCost;
    public $totalPrice;
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
            [['totalCost', 'totalPrice'], 'safe']
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
            'totalCost' => 'Costo Total',
            'totalPrice' => 'Precio Total',
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
    
    public function uploadSales() {
        $this->excelFile->saveAs('uploads/inventory/BocconciniSales.' . $this->excelFile->extension);
        return 'uploads/inventory/BocconciniSales.' . $this->excelFile->extension;
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
                ->select('tblproduct.id, tblproduct.code, tblproduct.name, tblinventory.quantity, tblproduct.cost, tblproduct.price, tblinventory.observation')
                ->addSelect('(tblproduct.price * tblinventory.quantity) as totalPrice')
                ->addSelect('(tblproduct.cost * tblinventory.quantity) as totalCost')
                ->join('LEFT JOIN', 'tblinventory', 'tblinventory.productid = tblproduct.id')
                ->asArray()
                ->all();
    }
    
     public function getInventoryTemplate(){
        return Product::find()
                ->select('tblproduct.id, tblproduct.code, tblproduct.name, tblinventory.quantity, tblproduct.cost, tblproduct.price, tblinventory.observation')
                ->join('LEFT JOIN', 'tblinventory', 'tblinventory.productid = tblproduct.id')
                ->asArray()
                ->all();
    }
    
    public function listInventory(){
        return Inventory::find()
                ->select('tblproduct.name, tblproduct.cost, tblproduct.price, tblinventory.*')
                ->addSelect('(tblproduct.price * tblinventory.quantity) as totalPrice')
                ->addSelect('(tblproduct.cost * tblinventory.quantity) as totalCost')
                ->joinWith(['product'])
                ->groupBy('tblproduct.name');
    }
    
    public function getTotals(){
        return Inventory::find()
                ->select('sum(tblproduct.price * tblinventory.quantity) as totalPrice')
                ->addSelect('sum(tblproduct.cost * tblinventory.quantity) as totalCost')
                ->join('JOIN','tblproduct','tblproduct.id = tblinventory.productid')
                ->asArray()->one();
    }
}
