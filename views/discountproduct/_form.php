<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Discountproduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discountproduct-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'prductid')->dropDownList(ArrayHelper::map($queryProduct, 'id', 'name')) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'discountid')->dropDownList(ArrayHelper::map($querydiscount, 'id', 'name')) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Modificar', ['class' => 'btn btn-primary btn-block']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
