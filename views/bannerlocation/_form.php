<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bannerlocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bannerlocation-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <br>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
