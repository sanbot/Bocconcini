<?php

namespace app\models;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\db\Query;
use yii\helpers\BaseUrl;

/**
 * This is the model class for table "tblproductimage".
 *
 * @property integer $id
 * @property string $text
 * @property string $ext
 * @property integer $productid
 *
 * @property Tblproduct $product
 */
class Productimage extends \yii\db\ActiveRecord {

    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblproductimage';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['productid'], 'integer'],
            [['text'], 'string', 'max' => 150],
            [['ext'], 'string', 'max' => 10],
            [['productid'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productid' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'text' => 'Descripción',
            'ext' => 'Imagen',
            'imageFile' => 'Imagen',
            'productid' => 'Producto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productid']);
    }
    
    public function upload($name, $productid) {
        BaseFileHelper::createDirectory('uploads/products/' . $productid);
        $this->imageFile->saveAs('uploads/products/' . $productid. '/' . $name . '.' . $this->imageFile->extension);
        return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }

    public function URLImage() {
        return $this->imageFile->extension;
    }

    public function findImagesProduct($id, $ext){
        $query = new Query;
        $query->select("*")
                ->from('tblproductimage')
                ->where('productid = '.$id);
        $command = $query->createCommand();
        $result = $command->queryAll();
        $data = array();
        array_push($data, '<img src="'. BaseUrl::base().'/uploads/products/'.$id.'.'.$ext.'" width="100%"/>');
        foreach($result as $row){
            array_push($data, '<img src="'. BaseUrl::base().'/uploads/products/'.$row['productid'].'/'.$row['id'].'.'.$row['ext'].'" width="100%"/>');
        }

        return $data;
    }
}
