<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tblproductcommentary".
 *
 * @property integer $id
 * @property string $commentary
 * @property integer $productid
 * @property integer $userid
 * @property integer $visible
 * @property integer $parentcommentaryid
 * @property string $date
 *
 * @property Tblproduct $product
 * @property Tbluser $user
 */
class Productcommentary extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblproductcommentary';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['commentary', 'productid', 'visible'], 'required'],
            [['productid', 'userid', 'visible', 'parentcommentaryid'], 'integer'],
            [['date'], 'safe'],
            [['commentary'], 'string', 'max' => 45],
            [['productid'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productid' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'commentary' => 'Comentario',
            'productid' => 'Producto',
            'userid' => 'Usuario',
            'visible' => 'Visible',
            'parentcommentaryid' => 'Comentario padre',
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
    
    public function findCommentsProduct($productid){
        $query = new Query;
        $query->select("com.id, com.commentary, user.name usuario, date, ( select count(id) from tblproductcommentary c where c.parentcommentaryid = com.id) as cantidad ")
                ->from('tblproductcommentary com')
                ->join('left join', 'tbluser user', 'user.id = com.userid')
                ->where('com.visible = 1')
                ->where('com.productid = ' . $productid)
                ->where('com.parentcommentaryid is null')
                ->orderBy('date desc');
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }
    
    public function findComments($id){
        $query = new Query;
        $query->select("com.id, com.commentary, user.name usuario, date, pro.name producto")
                ->from('tblproductcommentary com')
                ->join('left join', 'tbluser user', 'user.id = com.userid')
                ->join('left join', 'tblproduct pro', 'pro.id = com.productid')
                ->where('com.visible = 1')
                ->where('com.parentcommentaryid = ' . $id)
                ->orderBy('date asc');
        $command = $query->createCommand();
        $result = $command->queryAll();
        return $result;
    }

}
