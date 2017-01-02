<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tblproducto".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $precio
 * @property string $imagen
 * @property string $descripcion
 */
class Producto extends \yii\db\ActiveRecord {

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblproducto';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['precio'], 'number'],
            [['nombre'], 'string', 'max' => 100],
            [['imagen'], 'string', 'max' => 150],
            [['descripcion'], 'string', 'max' => 200],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Id',
            'nombre' => 'Nombre Producto',
            'precio' => 'Precio',
            'imagen' => 'Imagen',
            'descripcion' => 'Descripción',
        ];
    }

    public function upload($name) {
        $this->imageFile->saveAs('uploads/products/' . $name . '.' . $this->imageFile->extension);
        return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }

    public function URLImage() {

        return $this->imageFile->extension;
    }

}
