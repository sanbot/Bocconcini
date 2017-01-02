<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'Bocconcini | Admin';
$PT = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categoría de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productcategory-view">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que quiere eliminar la categoría?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'maincategory',
        ],
    ]) ?>

</div>
