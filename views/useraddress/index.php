<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Direcciones de usuarios';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="useraddress-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Agregar Dirección de usuario', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'users.name',
            'municipality.name',
            'alias',
            'district',
            'address',
            // 'commentary',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
