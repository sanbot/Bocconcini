<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Descuentos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="discount-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear Descuento', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'description',
            'percent',
            'initialdate:date',
            'finaldate:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
