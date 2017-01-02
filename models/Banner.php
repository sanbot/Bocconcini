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
 *
 * @property Tblbannerlocation $id0
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
            [['location'], 'integer'],
            [['extension'], 'string', 'max' => 10],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerlocation() {
        return $this->hasOne(Bannerlocation::className(), ['id' => 'id']);
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
                ->where('location = '.$id);
        $command = $query->createCommand();
        $result = $command->queryAll();
        $data = array();
        foreach($result as $row){
            array_push($data, '<img src="'. BaseUrl::base().'/uploads/banners/'.$row['id'].'.'.$row['extension'].'" width="100%"/>');
        }

        return $data;
    }
}
