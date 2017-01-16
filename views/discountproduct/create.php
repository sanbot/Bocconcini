<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Discountproduct */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Productos en Descuento', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="discountproduct-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryProduct' => $queryProduct,
        'querydiscount' => $querydiscount,
    ]) ?>

</div>
