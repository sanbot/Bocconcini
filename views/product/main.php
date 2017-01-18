<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseUrl;

$this->title = 'Bocconcini';
$PT = 'Productos';
$formatter = \Yii::$app->formatter;
?>
<div class="product-main">
    <div class="body-content">
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
        <div class="row">
            <?php foreach($products as $product){?>
                <div class="col-md-4">
                    <div class="bocconcini-product-item">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <a href="<?= BaseUrl::base().'/index.php?r=product%2Fview&id='.$product['id']?>"><img src="<?= BaseUrl::base().'/uploads/products/'.$product['id'].'.'.$product['imagen'] ?>" class="img-responsive" style="border-radius: 3%;"/></a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="row">
                                    <div class="col-md-1 col-md-offset-11">
                                        <a href="<?= BaseUrl::base().'/index.php?r=product%2Fview&id='.$product['id']?>" style="text-align: right;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Nombre</b></p>
                                        <p><?= $product['name']?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Precio</b></p>
                                        <p><?= $formatter->asCurrency($product['discount'] <$product['price']?$product['discount']:$product['price'])?></p>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="col-md-12">
                                        <p><b>Descripción</b></p>
                                        <p><?= $product['description']?></p>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php } ?>
        </div>

    </div>
</div>
