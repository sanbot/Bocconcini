<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Imagenes de productos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productimage-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product.name',
            //'text',
            //'ext',
            [
                'attribute' => 'atrimage',
                'label' => 'Ruta Imagen',
                'value' => function($model) { return BaseUrl::base().'/uploads/products/'.$model->productid.'/'.$model->id  . "." . $model->ext ;},
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
