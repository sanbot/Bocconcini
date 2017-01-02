<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'Bocconcini | Admin';
$PT = 'Modificar: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categoría de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificarr';
?>
<div class="productcategory-update">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryCategory' => $queryCategory,
    ]) ?>

</div>
