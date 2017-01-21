<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Useraddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="useraddress-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'municipalityid')->dropDownList(ArrayHelper::map($queryMunicipality, 'id', 'name')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($model, 'commentary')->textarea(['maxlength' => true, 'rows' => 4]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => 'btn btn-block btn-primary']) ?>
            </div>
        </div>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
