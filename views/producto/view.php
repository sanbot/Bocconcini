<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= BaseUrl::base().'/'.$model->imagen ?>" class="img-responsive" width="300px" alt="prueba"/>
        </div>
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'nombre',
                    'precio',
                    'imagen',
                    'descripcion',
                ],
            ]) ?>
        </div>
    </div>

</div>
