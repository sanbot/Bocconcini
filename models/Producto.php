<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblproducto".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $precio
 * @property string $imagen
 * @property string $descripcion
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblproducto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['precio'], 'number'],
            [['nombre'], 'string', 'max' => 100],
            [['imagen'], 'string', 'max' => 150],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'nombre' => 'Nombre Producto',
            'precio' => 'Precio',
            'imagen' => 'Imagen',
            'descripcion' => 'Descripción',
        ];
    }
}
