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
                                <?php if($product['discount'] <$product['price']) {?>
                                    <img src="<?= BaseUrl::base().'/uploads/site/bigsale.png'?>" class="img-responsive bigsale"/>
                                <?php } ?>
                                <a href="<?= BaseUrl::base().'/index.php?r=product%2Fview&id='.$product['id']?>"><img src="<?= BaseUrl::base().'/uploads/products/'.$product['id'].'.'.$product['imagen'] ?>" class="img-responsive img-producto"/></a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><a href="<?= BaseUrl::base().'/index.php?r=product%2Fview&id='.$product['id']?>" class="label-linkproduct"><?= $product['name']?></a></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Por: <b>$<?= $formatter->asDecimal($product['discount'] <$product['price']?$product['discount']:$product['price'])?></b></p>
                                        <?php if($product['discount'] <$product['price']) {?>
                                            <p>Antes: <b style="text-decoration:line-through;">$<?= $formatter->asDecimal($product['price']) ?></b></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php } ?>
        </div>

    </div>
</div>
