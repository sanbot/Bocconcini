<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblproductcategory".
 *
 * @property integer $id
 * @property string $name
 * @property integer $maincategory
 *
 * @property Tblproduct $tblproduct
 */
class Productcategory extends \yii\db\ActiveRecord
{
    public $main;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblproductcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'maincategory'], 'required'],
            [['maincategory'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['main'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'name' => 'Categoría',
            'maincategory' => 'Categoría Padre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblproduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'category']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductcategory()
    {
        return $this->hasOne(Productcategory::className(), ['id' => 'maincategory']);
    }
}
