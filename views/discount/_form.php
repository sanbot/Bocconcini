<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bootui\datepicker\Datepicker;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0] ) ? 'has-error' : '' ?>">
                <label class="control-label" for="banner-location">Fecha inicial</label>
                <?= Datepicker::widget([
                    'model' => $model,
                    'attribute' => 'initialdate',
                    'format' => 'yyyy-mm-dd',
                    'language' => 'es',
                    'todayBtn' => true,
                ]) ?>
               <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0]) ? ' <div class="help-block">'.Yii::$app->session->getFlash('error')['initialdate'][0].'</div>' : '' ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0] ) ? 'has-error' : '' ?>">
                <label class="control-label" for="banner-location">Fecha inicial</label>
                <?= Datepicker::widget([
                    'model' => $model,
                    'attribute' => 'finaldate',
                    'format' => 'yyyy-mm-dd',
                    'language' => 'es',
                    'todayBtn' => true,
                ]) ?>
               <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0]) ? ' <div class="help-block">'.Yii::$app->session->getFlash('error')['initialdate'][0].'</div>' : '' ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($model, 'percent')->input('number') ?>
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
