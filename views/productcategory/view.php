<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Productcategory */

$this->title = 'Bocconcini | Admin';
$PT = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categoría de productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productcategory-view">

    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-categoria">
            <div class="row">
                <div class="col-md-12"><h3 class="title-profile">Categoría: <?= Html::encode($PT) ?></h3></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= BaseUrl::base().'/uploads/categories/'.$model->id.'.'.$model->imagen ?>" class="img-responsive" style="border-radius: 5%;"/>
                </div>
                <div class="col-md-8">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'name',
                            'main',
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
                            'confirm' => '¿Está seguro que quiere eliminar la categoría?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
