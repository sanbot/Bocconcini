<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categoryproducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoryproducts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'productid')->textInput() ?>

    <?= $form->field($model, 'categoryid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
