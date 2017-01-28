<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblcategoryproducts".
 *
 * @property integer $id
 * @property integer $productid
 * @property integer $categoryid
 *
 * @property Tblproductcategory $category
 * @property Tblproduct $product
 */
class Categoryproducts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblcategoryproducts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['productid', 'categoryid'], 'integer'],
            [['categoryid'], 'exist', 'skipOnError' => true, 'targetClass' => Productcategory::className(), 'targetAttribute' => ['categoryid' => 'id']],
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
            'categoryid' => 'Categoría',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Productcategory::className(), ['id' => 'categoryid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productid']);
    }

    public function listCategoryProducts($id){
        return Categoryproducts::find()->joinWith(['category', 'product'])->where(['tblproduct.id' => $id]);
    }
}
