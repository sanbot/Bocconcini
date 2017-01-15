<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Productimage */

$this->title = 'Bocconcini | Admin';
$PT = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagenes de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productimage-view">

    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-product">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-product">Imagene: <?= Html::encode($PT) ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= BaseUrl::base().'/uploads/products/'.$model->productid.'/'.$model->id.'.'.$model->ext ?>" class="img-responsive" style="border-radius: 5%;"/>
                </div>
                <div class="col-md-8">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'text',
                            //'ext',
                            //'productid',
                        ],
                        'template' => '<div class="row"><div class="col-md-3"><p class="item-label"><b>{label}</b></p></div><div class="col-md-9"><p class="item-value">{value}</p></div></div>',
                    ]) ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Está seguro que quiere eliminar esta imagen?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
