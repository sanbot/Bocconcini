<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\BaseUrl;

/**
 * This is the model class for table "tblbanner".
 *
 * @property integer $id
 * @property string $extension
 * @property integer $location
 * @property string $initialdate
 * @property string $finaldate
 * @property integer $order
 *
 * @property Tblbannerlocation $location0
 */
class Banner extends \yii\db\ActiveRecord {

    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tblbanner';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['location', 'order'], 'integer'],
            [['initialdate', 'finaldate'], 'safe'],
            [['extension'], 'string', 'max' => 10],
            [['location'], 'exist', 'skipOnError' => true, 'targetClass' => Bannerlocation::className(), 'targetAttribute' => ['location' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['initialdate', 'compare', 'compareAttribute' => 'finaldate', 'operator' => '<', 'message' => 'Fecha inicial debe ser menor a Fecha final.'],
            [['location', 'order', 'extension'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'extension' => 'Imagen',
            'location' => 'Ubicación',
            'initialdate' => 'Fecha inicial',
            'finaldate' => 'Fecha Final',
            'order' => 'Orden',
            'imageFile' => 'Imagen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerlocation() {
        return $this->hasOne(Bannerlocation::className(), ['id' => 'location']);
    }

    public function upload($name) {
        $this->imageFile->saveAs('uploads/banners/' . $name . '.' . $this->imageFile->extension);
        return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
    }

    public function URLImage() {

        return $this->imageFile->extension;
    }

    public function findBannerImages($id){
        $query = new Query;
        $query->select("id,extension")
                ->from('tblbanner')
                ->where('location = '.$id . ' and ((curdate() between initialdate and finaldate) or (finaldate is null and initialdate is null))')
                ->orderBy('order asc');
        $command = $query->createCommand();
        $result = $command->queryAll();
        $data = array();
        foreach($result as $row){
            array_push($data, '<img src="'. BaseUrl::base().'/uploads/banners/'.$row['id'].'.'.$row['extension'].'" width="100%"/>');
        }

        return $data;
    }
}
