<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbluser".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $roleid
 *
 * @property Tblrole $role
 */
class Users extends \yii\db\ActiveRecord {

    public $password_repeat;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tbluser';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['roleid'], 'integer'],
            [['name', 'password'], 'string', 'max' => 200],
            [['username'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 100],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['roleid'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['roleid' => 'id']],
            ['email', 'email'],
            [['name', 'username', 'password', 'email', 'password_repeat'], 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Las contraseñas no coinciden"],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Solo se pueden insertar letras y números.'],
            //['password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,30}$/i', 'message' => 'La contraseña debe tener mínimo una letra mayúscula, una letra minúscula, y un número. Debe tener entre 6 y 30 Carácteres.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'Código',
            'name' => 'Nombre Completo',
            'username' => 'Usuario',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir Contraseña',
            'roleid' => 'Rol',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole() {
        return $this->hasOne(Role::className(), ['id' => 'roleid']);
    }

}
