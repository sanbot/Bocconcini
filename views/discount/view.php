<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */

$this->title = 'Bocconcini | Admin';
$PT = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Descuentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="discount-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-categoria">
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Descuento: <?= Html::encode($PT) ?></h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'name',
                            'description',
                            'percent',
                            'initialdate',
                            'finaldate',
                        ],
                        'template' => '<div class="row"><div class="col-md-3"><p class="item-label"><b>{label}</b></p></div><div class="col-md-9"><p class="item-value">{value}</p></div></div>',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Está seguro que quiere eliminar este descuento?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <h3  class="title-profile">Productos</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=discountproduct/add']); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($modelDiscountproduct, 'prductid')->dropDownList(ArrayHelper::map($queryProduct, 'id', 'name')); ?>
                            </div>
                            <div class="hidden">
                                <?= $form->field($modelDiscountproduct, 'discountid')->input('text', ['value' => $model->id]) ?>
                            </div>
                            <div class="col-md-6">
                                <label></label>
                                <?= Html::submitButton('Agregar', ['class' => 'btn btn-primary btn-block']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderProducts,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'product.name',
                            'discount.name',
                            'discount.percent',

                            //['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>
