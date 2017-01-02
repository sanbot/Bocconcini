<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bannerlocation */

$this->title = 'Bocconcini | Admin';
$this->params['breadcrumbs'][] = ['label' => 'Ubicación de Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="bannerlocation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
