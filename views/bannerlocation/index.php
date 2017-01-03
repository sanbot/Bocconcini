<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Ubicación de Banners';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="bannerlocation-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear Ubicación de Banner', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'location',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
