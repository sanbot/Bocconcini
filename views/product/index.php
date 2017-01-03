<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Productos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="product-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear Producto', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'price',
            //'imagen',
            //'description',
            'productcategory.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
