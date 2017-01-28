<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Productos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="product-index">

    <h1><?= Html::encode($PT) ?></h1>
    
    <div class="row">
        <div class="productimage-form">
            <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=product']); ?>
                <div class="col-md-8">
                    <?= $form->field($model, 'description')->textInput()->label('Buscar') ?>
                </div>
                <div class="col-md-2">
                    <br>
                    <div class="form-group">
                        <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
    <p>
        <?= Html::a('Crear Producto', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'price:decimal',
            //'imagen',
            //'description',
            'productcategory.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
