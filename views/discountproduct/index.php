<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Productos en Descuento';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="discountproduct-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Agregar Producto a un descuento', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'product.name',
            'discount.name',
            'discount.percent',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
