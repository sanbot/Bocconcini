<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Productimage */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Imagenes de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productimage-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'queryProduct' => $queryProduct,
    ]) ?>

</div>
