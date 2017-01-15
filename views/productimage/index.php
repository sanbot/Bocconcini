<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bocconcini | Admin';
$PT = 'Imagenes de productos';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="productimage-index">

    <h1><?= Html::encode($PT) ?></h1>

    <div class="row">
        <div class="productimage-form">
            <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=productimage']); ?>
                <div class="col-md-8">
                    <?= $form->field($model, 'productid')->dropDownList(ArrayHelper::map($queryProduct, 'id', 'name')) ?>
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
        <?= Html::a('Crear', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product.name',
            //'text',
            //'ext',
            [
                'attribute' => 'atrimage',
                'label' => 'Ruta Imagen',
                'value' => function($model) { return BaseUrl::base().'/uploads/products/'.$model->productid.'/'.$model->id  . "." . $model->ext ;},
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
