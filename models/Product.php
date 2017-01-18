<?php

namespace app\models;
use yii\db\Query;

use Yii;

/**
 * This is the model class for table "tblproduct".
 *
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property string $imagen
 * @property string $description
 * @property integer $category
 *
 * @property Tblproductcategory $category0
 * @property Tblproductimage[] $tblproductimages
 */
class Product extends \yii\db\ActiveRecord {

    public $discount;
    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblproduct';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'price', 'imagen', 'category'], 'required'],
            [['price'], 'number'],
            [['category'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['imagen'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 700],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Productcategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['discount', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'name' => 'Producto',
            'price' => 'Precio',
            'imagen' => 'Imagen',
            'description' => 'Descripción',
            'category' => 'Categoría',
            'imageFile' => 'Imagen',
            'discount' => 'Precio con descuento'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductcategory() {
        return $this->hasOne(Productcategory::className(), ['id' => 'category']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductimages() {
        return $this->hasMany(Productimage::className(), ['productid' => 'id']);
    }
    
    public function getDiscountproducts() {
        return $this->hasMany(Discountproduct::className(), ['productid' => 'id']);
    }

    public function upload($name) {
        $this->imageFile->saveAs('uploads/products/' . $name . '.' . $this->imageFile->extension);
        return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }

    public function URLImage() {
        return $this->imageFile->extension;
    }

    public function findProductsHomePage($description){
        $query = new Query;
        $query->select("pro.id, pro.name, pro.imagen, pro.description, pro.category, pro.price, if(dis.percent is null, pro.price, pro.price * (1- (dis.percent / 100)))  as discount ")
                ->from('tblproduct pro')
                ->join('left join', 'tbldiscountproduct dispro', 'dispro.prductid = pro.id')
                ->join('left join', 'tbldiscount dis', 'dispro.discountid = dis.id and curdate() between dis.initialdate and dis.finaldate')
                ->orWhere('pro.name like \'%' . $description . '%\'')
                ->orWhere('pro.description like \'%' . $description . '%\'');
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }
}
