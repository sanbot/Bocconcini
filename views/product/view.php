<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\BaseUrl;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\bootstrap\Carousel;


/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Bocconcini | Admin';
$PT = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;

$formatter = \Yii::$app->formatter;
?>
<div class="product-view">
    <p>
        <?= Yii::$app->user->isGuest ? ('') : Yii::$app->user->identity->roleid == 1 ? (Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])) : ('') ?>
        <?= Yii::$app->user->isGuest ? ('') : Yii::$app->user->identity->roleid == 1 ? (Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que quiere elimianr este producto?',
                'method' => 'post',
            ],
        ])) : ('') ?>
        <?php 
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->roleid == 1){
            Modal::begin([
                'header' => '<h2>Agregar imagenes</h2>',
                'toggleButton' => ['label' => 'Agregar imagenes', 'class' => 'btn btn-primary'],
            ]);
        ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="productimage-form">

                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => BaseUrl::base().'/index.php?r=productimage/create']); ?>

                        <?= $form->field($modelProductImage, 'imageFile')->fileInput() ?>

                        <?= $form->field($modelProductImage, 'text')->textarea(['maxlength' => true, 'rows'=>'6']) ?>
                        <div class="hidden">
                        <?= $form->field($modelProductImage, 'productid')->input('text', ['value' => $model->id]) ?>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton($modelProductImage->isNewRecord ? 'Crear' : 'Modificar', ['class' => 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
            <?php Modal::end();
        }?>
        
    </p>
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-product">
            <div class="row">
                <div class="col-md-12"><h1 class="center label-productname"><?= Html::encode($PT) ?></h1></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= Carousel::widget([
                            'items' => $banner
                        ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="label-price">$ <?= $formatter->asDecimal($model->price) ?></p>
                        </div>
                    </div>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            //'name',
                            'productcategory.name',
                            'description',
                        ],
                        'template' => '<div class="row"><div class="col-md-12"><p class="item-label"><b>{label}</b></p><p class="item-value">{value}</p></div></div>',
                    ]) ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-md-offset-3">
                    <div class="form-group">
                        <label class="control-label" for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" min="0" max="100"/>
                    </div>
                </div>
                <div class="col-md-3">  
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Comprar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1 bocconcini-product">
            <div class="row">
                <div class="col-md-12"><h3 class="center">Comentarios</h3></div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    
                    <?php $form = ActiveForm::begin(['action' => BaseUrl::base().'/index.php?r=productcommentary/add']); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($modelProductCommentary, 'commentary')->textarea(['maxlength' => true, 'row' => 7]) ?>
                        </div>
                        <div class="hidden">
                            <?= $form->field($modelProductCommentary, 'productid')->input('text', ['value' => $model->id]) ?>
                        </div>
                        <div class="col-md-4">
                            <label></label>
                            <div class="form-group">
                                <?= Html::submitButton('Comentar', ['class' => 'btn btn-block btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    
                    <?php foreach($comments as $comment){?>
                    <div class="row">
                        <div class="col-md-2">
                            <img class="img-responsive user-photo" src="<?= BaseUrl::base().'/uploads/' ?>site/logo_bococcini.png">
                        </div><!-- /col-sm-1 -->

                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong><?=$comment['usuario']?></strong> <span class="text-muted">commented <?=$comment['date']?></span>
                                </div>
                                <div class="panel-body">
                                    <?=$comment['commentary']?>
                                    <br>
                                    <?= Html::a('Responder ' , ['productcommentary/showcomments', 'id' => $comment['id']]) ?> - <?= $comment['cantidad']?> <?= Html::a('Respuestas ' , ['productcommentary/showcomments', 'id' => $comment['id']]) ?>
                                </div><!-- /panel-body -->
                            </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->
                    </div><!-- /row -->
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>
