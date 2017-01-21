<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Municipality */

$this->title = 'Bocconcini | Admin';
$PT = 'Modificar ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="municipality-update">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
