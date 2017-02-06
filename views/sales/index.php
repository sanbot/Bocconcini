<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use bootui\datepicker\Datepicker;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Ventas';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="sales-index">

    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-categoria">
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile"><?= Html::encode($PT) ?></h3></div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="banner-location">Fecha inicial</label>
                            <?= Datepicker::widget([
                                'model' => $model,
                                'attribute' => 'startdate',
                                'format' => 'yyyy-mm-dd',
                                'language' => 'es',
                                'options' => ['required' => true]
                            ]) ?>
                            <!--<?= $form->field($model, 'startdate')->textInput() ?>-->
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="banner-location">Fecha inicial</label>
                            <?= Datepicker::widget([
                                'model' => $model,
                                'attribute' => 'enddate',
                                'format' => 'yyyy-mm-dd',
                                'language' => 'es',
                                'options' => ['required' => true]
                            ]) ?>
                            <!--<?= $form->field($model, 'enddate')->textInput() ?>-->
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="form-group">
                                <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary btn-block']) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>  
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'productid',
                            'quantity',
                            'observation',
                            'date',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
