<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Categoría de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productcategory-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryCategory' => $queryCategory,
    ]) ?>

</div>
