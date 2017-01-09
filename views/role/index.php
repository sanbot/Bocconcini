<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Roles';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="role-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
