<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Bocconcini';
$PT = 'Contáctenos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="site-contact">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h1><?= Html::encode($PT) ?></h1>
                
                <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                    <div class="alert alert-success">
                        Gracias por contactarnos. Responderemos lo más pronto posible.
                    </div>

                <?php else: ?>

                <p>
                    Si tiene preguntas de negocio u otras preguntas, por favor llene el siguiente formulario para contactarnos.
                    Gracias.
                </p>
                
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->input('text', ['autofocus' => true, 'value'=> isset(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : '']) ?>

                    <?= $form->field($model, 'email')->input('email', ['value'=> isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '']) ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
