<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Inventory */

$this->title = 'Bocconcini | Admin';
$PT = 'Cargar Inventario';
$this->params['breadcrumbs'][] = ['label' => 'Inventario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="inventory-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form_upload', [
        'model' => $model,
    ]) ?>

</div>
