<?php

namespace app\models;

use Yii;
use yii\db\Query;

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
 * @property Tblproductcategory $id0
 */
class Product extends \yii\db\ActiveRecord {

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
            [['name', 'price', 'imagen', 'category', 'imageFile'], 'required'],
            [['price'], 'number'],
            [['category'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['imagen'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 700],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Productcategory::className(), 'targetAttribute' => ['id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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
            'imageFile' => 'Imagen',
            'description' => 'Descripción',
            'category' => 'Categoría',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductcategory() {
        return $this->hasOne(Productcategory::className(), ['id' => 'category']);
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
        $query->select("*")
                ->from('tblproduct')
                ->orWhere('tblproduct.name like \'%' . $description . '%\'')
                ->orWhere('tblproduct.description like \'%' . $description . '%\'');
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductimages()
    {
        return $this->hasMany(Productimage::className(), ['productid' => 'id']);
    }
}
