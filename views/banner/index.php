<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Banners';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="banner-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Agregar Imagen a Banner', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'extension',
            'bannerlocation.location',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
