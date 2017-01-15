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

    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-categoria">
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Ubicación de Banner: <?= Html::encode($PT) ?></h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'location',
                        ],
                        'template' => '<div class="row"><div class="col-md-3"><p class="item-label"><b>{label}</b></p></div><div class="col-md-9"><p class="item-value">{value}</p></div></div>',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Está seguro que desea eliminar esta ubicación?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
