<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Productcommentary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productcommentary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'commentary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'productid')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'visible')->textInput() ?>

    <?= $form->field($model, 'parentcommentaryid')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
