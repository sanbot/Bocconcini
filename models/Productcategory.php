<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tblproductcategory".
 *
 * @property integer $id
 * @property string $name
 * @property integer $maincategory
 * @property string $imagen
 *
 * @property Tblproduct[] $tblproducts
 */
class Productcategory extends \yii\db\ActiveRecord {

    public $imageFile;
    public $main;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblproductcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'maincategory'], 'required'],
            [['maincategory'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['imagen'], 'string', 'max' => 10],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
            ['main', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Categoria',
            'maincategory' => 'Categoría Padre',
            'imagen' => 'Imagen',
            'imageFile' => 'Imagen',
            'main' => 'Categoría Padre'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts() {
        return $this->hasMany(Product::className(), ['category' => 'id']);
    }

    public function getProductcategory() {
        return $this->hasOne(Productcategory::className(), ['id' => 'maincategory']);
    }

    public function upload($name) {
        $this->imageFile->saveAs('uploads/categories/' . $name . '.' . $this->imageFile->extension);
        return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }

    public function URLImage() {
        return $this->imageFile->extension;
    }

    public function listCategories() {
        return Productcategory::find()
                        ->joinWith(['productcategory pc'])
                        ->select(['tblproductcategory.id', 'tblproductcategory.name', 'pc.name main']);
    }

    public function findModel($id) {
        return Productcategory::find()
                        ->select('tblproductcategory.id, tblproductcategory.name, catpad.name as main, tblproductcategory.imagen')
                        ->join('left join', ['tblproductcategory as catpad'], 'catpad.id = tblproductcategory.maincategory')
                        ->where(['tblproductcategory.id' => $id])
                        ->one();
    }

    public function listCategoriesProduct($productid) {
        return Productcategory::find()->where('id <> 1 and id <> ' . $productid)->all();
    }
    
    public function listParentCategories() {
        return Productcategory::find()->where('id <> 1 and maincategory = 1')->all();
    }

}
