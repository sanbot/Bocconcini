<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bannerlocation */

$this->title = 'Bocconcini | Admin';
$PT = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ubicación de Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="bannerlocation-view">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar esta ubicación?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'location',
        ],
    ]) ?>

</div>
