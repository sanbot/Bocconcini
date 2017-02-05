<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Inventario';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="inventory-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Cambiar inventario de producto', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Descargar inventario', ['downloadinventory'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cargar inventario', ['uploadinventory'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'product.name',
            'quantity',
            'observation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
