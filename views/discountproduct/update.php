<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Discountproduct */

$this->title = 'Bocconcini | Admin';
$PT = 'Modificar ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Productos en Descuento', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="discountproduct-update">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryProduct' => $queryProduct,
        'querydiscount' => $querydiscount,
    ]) ?>

</div>
