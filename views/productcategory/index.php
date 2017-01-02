<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Categoría de productos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productcategory-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear Categoria de productos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'maincategory',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
