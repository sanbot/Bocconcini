<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Bocconcini | Sing up';
$PT = 'Regístrate';
$this->params['breadcrumbs'][] = ['label' => 'Regístrate', 'url' => ['singup']];
$this->params['breadcrumbs'][] = $PT;
?>

<div class="users-signup">

    <h1><?= Html::encode($PT) ?></h1>

    <div class="users-form">

        <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=users/singup']); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
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

</div>
