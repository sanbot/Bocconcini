<?php
/* @var $this yii\web\View */

use yii\bootstrap\Carousel;
use yii\helpers\BaseUrl;

$this->title = 'Bocconcini';
$formatter = \Yii::$app->formatter;
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <?= Carousel::widget([
                    'items' => $banner
                ]);?>
            </div>
        </div>
        <br><br>
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
                                        
                                    </div>
                                </div>
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
