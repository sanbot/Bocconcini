<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Categoryproducts */

$this->title = 'Bocconcini | Admin';
$PT = 'Agregar producto a una categoría';
$this->params['breadcrumbs'][] = ['label' => 'Categorías y productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="categoryproducts-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
