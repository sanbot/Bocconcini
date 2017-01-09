<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Productimage */

$this->title = 'Bocconcini | Admin';
$PT = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagenes de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productimage-view">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que quiere eliminar esta imagen?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text',
            //'ext',
            //'productid',
        ],
    ]) ?>

</div>