<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Usuarios';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="users-index">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'username',
            'email:email',
            //'password',
            // 'roleid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
