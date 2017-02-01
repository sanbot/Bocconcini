<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblfavorite".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $productid
 * @property string $date
 *
 * @property Tblproduct $product
 * @property Tbluser $user
 */
class Favorite extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblfavorite';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['userid', 'productid'], 'integer'],
            [['date'], 'safe'],
            [['productid'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productid' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Codigo',
            'userid' => 'Usuario',
            'productid' => 'Producto',
            'date' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'productid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
    
    public function findFavorite($userid, $productid){
        return Favorite::find()->where(['userid' => $userid, 'productid' => $productid])->one();
    }

    public function findId($userid, $productid){
        return Favorite::find()->where(['userid' => $userid, 'productid' => $productid])->one()->id;
    }
}
