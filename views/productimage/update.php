<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productimage */

$this->title = 'Bocconcini | Admin';
$PT = 'Modificar ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagenes de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="productimage-update">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryProduct' => $queryProduct,
    ]) ?>

</div>
