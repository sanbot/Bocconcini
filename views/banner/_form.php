<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use bootui\datepicker\Datepicker;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'location')->dropDownList(ArrayHelper::map($queryBannerLocation, 'id', 'location')) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'imageFile')->fileInput() ?>
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
                ]) ?>
               <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0]) ? ' <div class="help-block">'.Yii::$app->session->getFlash('error')['initialdate'][0].'</div>' : '' ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0] ) ? 'has-error' : '' ?>">
                <label class="control-label" for="banner-location">Fecha final</label>
                <?= Datepicker::widget([
                    'model' => $model,
                    'attribute' => 'finaldate',
                    'format' => 'yyyy-mm-dd',
                    'language' => 'es',
                ]) ?>
                <?= isset(Yii::$app->session->getFlash('error')['initialdate'][0]) ? ' <div class="help-block">'.Yii::$app->session->getFlash('error')['initialdate'][0].'</div>' : '' ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($model, 'order')->input('number') ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Modificar', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
