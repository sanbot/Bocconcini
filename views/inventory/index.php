<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Inventario';
$this->params['breadcrumbs'][] = $PT;
$formatter = \Yii::$app->formatter;
?>
<div class="inventory-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Cambiar inventario de producto', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Plantilla Inventario', ['downloadinventorytemplate'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Plantilla Ventas', ['downloadsalestemplate'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cargar inventario', ['uploadinventory'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cargar Ventas', ['uploadsales'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inventario Final', ['downloadinventory'], ['class' => 'btn btn-primary']) ?>
    </p>
    <br>
    <div class="row">
        <div class="col-md-12">
            <p class="inventory-totals">Costo total: $ <?= $formatter->asDecimal($totalCost) ?> - Precio total: $ <?= $formatter->asDecimal($totalPrice) ?></p>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'product.name',
            'quantity',
            'product.cost',
            'totalCost',
            'product.price',
            'totalPrice',
            'observation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
