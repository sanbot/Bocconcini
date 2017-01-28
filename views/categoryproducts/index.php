<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Categorías y productos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="categoryproducts-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Agregar productos a categorías', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'productid',
            'categoryid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
