<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productcategory-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'maincategory')->dropDownList(ArrayHelper::map($queryCategory, 'id', 'name')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
