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
 * @property double $cost
 * @property integer $minage
 * @property integer $maxage
 *
 * @property Tblcategoryproducts[] $tblcategoryproducts
 * @property Tbldiscountproduct[] $tbldiscountproducts
 * @property Tblfavorite[] $tblfavorites
 * @property Tblproductcategory $category0
 * @property Tblproductcommentary[] $tblproductcommentaries
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
            [['price', 'cost'], 'number', 'min' => 1, 'tooSmall' => 'No puede ser menor 1.'],
            [['category', 'minage', 'maxage'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['imagen'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 700],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Productcategory::className(), 'targetAttribute' => ['category' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
            ['discount', 'safe'],
            [['minage', 'maxage'], 'number','min'=>1, 'max'=>100,'tooSmall'=>'No puede seleccionar una edad menor a 1.', 'tooBig'=>'No puede seleccionar una edad mayor a 100.'],
            ['minage', 'compare', 'compareAttribute' => 'maxage', 'operator' => '<', 'message' => 'La edad mínima debe ser menor a la edad máxima.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'name' => 'Nombre',
            'price' => 'Precio',
            'imagen' => 'Imagen',
            'description' => 'Descripción',
            'category' => 'Categoría',
            'cost' => 'Costo',
            'minage' => 'Edad Mínima',
            'maxage' => 'Edad Máxima',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryproducts() {
        return $this->hasMany(Categoryproducts::className(), ['productid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscountproducts() {
        return $this->hasMany(Discountproduct::className(), ['prductid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites() {
        return $this->hasMany(Favorite::className(), ['productid' => 'id']);
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
    public function getProductcommentaries() {
        return $this->hasMany(Tblproductcommentary::className(), ['productid' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblinventories() {
        return $this->hasMany(Inventory::className(), ['productid' => 'id']);
    }

    public function upload($name) {
        $this->imageFile->saveAs('uploads/products/' . $name . '.' . $this->imageFile->extension);
        return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }

    public function URLImage() {
        return $this->imageFile->extension;
    }

    public function findProductsHomePage($description) {
        $query = new Query;
        $query->select("pro.id, pro.name, pro.imagen, pro.description, pro.category, pro.price, if(dis.percent is null, pro.price, pro.price * (1- (dis.percent / 100)))  as discount ")
                ->from('tblproduct pro')
                ->join('left join', 'tblcategoryproducts cp', 'cp.productid = pro.id')
                ->join('left join', 'tbldiscountproduct dispro', 'dispro.prductid = pro.id')
                ->join('left join', 'tbldiscount dis', 'dispro.discountid = dis.id and curdate() between dis.initialdate and dis.finaldate')
                ->where('dis.id is not null or cp.categoryid = 6 or pro.category = 6');
        if ($description != '') {
            $query = $query->orWhere('pro.name like \'%' . $description . '%\'')
                    ->orWhere('pro.description like \'%' . $description . '%\'');
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }

    public function findProducts($description) {
        $query = new Query;
        $query->select("pro.id, pro.name, pro.imagen, pro.description, pro.category, pro.price, if(dis.percent is null, pro.price, pro.price * (1- (dis.percent / 100)))  as discount ")
                ->distinct()
                ->from('tblproduct pro')
                ->join('left join', 'tbldiscountproduct dispro', 'dispro.prductid = pro.id')
                ->join('left join', 'tbldiscount dis', 'dispro.discountid = dis.id and curdate() between dis.initialdate and dis.finaldate');
        if ($description != '') {
            $query = $query->orWhere('pro.name like \'%' . $description . '%\'')
                    ->orWhere('pro.description like \'%' . $description . '%\'');
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }

    public function findProductsByCategory($description, $categoryid) {
        $query = new Query;
        $query->select("pro.id, pro.name, pro.imagen, pro.description, pro.category, pro.price, if(dis.percent is null, pro.price, pro.price * (1- (dis.percent / 100)))  as discount ")
                ->distinct()
                ->from('tblproduct pro')
                ->join('left join', 'tblcategoryproducts cp', 'cp.productid = pro.id')
                ->join('left join', 'tbldiscountproduct dispro', 'dispro.prductid = pro.id')
                ->join('left join', 'tbldiscount dis', 'dispro.discountid = dis.id and curdate() between dis.initialdate and dis.finaldate')
                ->orWhere('pro.category = ' . $categoryid)
                ->orWhere('cp.categoryid = ' . $categoryid);
        if ($description != '') {
            $query = $query->orWhere('pro.name like \'%' . $description . '%\'')
                    ->orWhere('pro.description like \'%' . $description . '%\'');
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }

    public function findProductsAdmin() {
        return Product::find()
                        ->joinWith(['productcategory'])
                        ->join('left join', 'tblcategoryproducts', 'tblcategoryproducts.productid = tblproduct.id');
    }

    public function findProductsAdminByCategory($categoryid) {
        return Product::find()->distinct()
                        ->joinWith(['productcategory'])
                        ->join('left join', 'tblcategoryproducts', 'tblcategoryproducts.productid = tblproduct.id')
                        ->orWhere('tblproduct.category = ' . $categoryid)
                        ->orWhere('tblcategoryproducts.categoryid = ' . $categoryid);
    }

    public function listProducts() {
        return Product::find()
                        ->join('left join', 'tbldiscountproduct', 'tblproduct.id = tbldiscountproduct.prductid')
                        ->where('tbldiscountproduct.prductid is null')->all();
    }

    public function listFavotiteProduct($userid, $description) {
        $query = new Query;
        $query->select("pro.id, pro.name, pro.imagen, pro.description, pro.category, pro.price, if(dis.percent is null, pro.price, pro.price * (1- (dis.percent / 100)))  as discount ")
                ->from('tblproduct pro')
                ->join('join', 'tblfavorite fav', 'fav.productid = pro.id AND fav.userid = ' . $userid)
                ->join('left join', 'tblcategoryproducts cp', 'cp.productid = pro.id')
                ->join('left join', 'tbldiscountproduct dispro', 'dispro.prductid = pro.id')
                ->join('left join', 'tbldiscount dis', 'dispro.discountid = dis.id and curdate() between dis.initialdate and dis.finaldate');
        if ($description != '') {
            $query = $query->orWhere('pro.name like \'%' . $description . '%\'')
                    ->orWhere('pro.description like \'%' . $description . '%\'');
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }

}
