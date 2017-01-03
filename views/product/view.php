<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Bocconcini | Admin';
$PT = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="product-view">

    <h1><?= Html::encode($PT) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que quiere elimianr este producto?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="row bocconcini-product">
                <div class="col-md-5">
                    <img src="<?= BaseUrl::base().'/uploads/products/'.$model->id.'.'.$model->imagen ?>" class="img-responsive" style="border-radius: 5%;"/>
                </div>
                <div class="col-md-7">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'price',
                            'category',
                            'description',
                        ],
                        'template' => '<div class="row"><div class="col-md-4"><p style="text-align:right;"><b>{label}</b></p></div><div class="col-md-8"><p>{value}</div></div>',
                    ]) ?>
                </div>
            </div>
            <div class="row bocconcini-product">
                <div class="col-md-3 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-block">Comprar</button>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block">Imagenes</button>
                </div>
            </div>
        </div>
    </div>

    

</div>
