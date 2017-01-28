<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categoryproducts */

$this->title = 'Bocconcini | Admin';
$this->params['breadcrumbs'][] = ['label' => 'Categoría y productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="categoryproducts-view">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro que quiere eliminar este producto de la categoría?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'productid',
            'categoryid',
        ],
    ]) ?>

</div>
