<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\BaseUrl;
use app\models\Banner;
use app\models\Productcategory;

AppAsset::register($this);
$img = Banner::find()->where('location = 2')->one();
if(!isset($img)){
    $img = new stdClass();
    $img->id = '';
    $img->extension = '';
}
$categoriesproduct = new Productcategory();
$categories = $categoriesproduct->listParentCategories();
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= BaseUrl::base().'/uploads/site'?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= BaseUrl::base().'/uploads/site'?>/favicon.ico" type="image/x-icon">
    <meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
 
<div class="wrap">
    <div id="banner" class="<?= ($img->id == '') ? 'hidden' : ''?>">
        <div class="row banner-menu" style="background-image: url(<?=  BaseUrl::base().'/uploads/banners/'.$img->id.'.'.$img->extension ?>);">
            <div class="container">
                <div class="pull-left link-bannermenu">
                    <?= Html::a('Nosotros', ['/site/about']). ' / ' ?>
                    <?= Html::a('Contáctenos', ['/site/contact']) ?>
                </div>
                <div class="pull-right link-bannermenu <?= (!Yii::$app->user->isGuest) ? 'hidden' : ''?>">
                    <?php if(Yii::$app->user->isGuest){ 
                        echo Html::a('Login', ['/site/login']). ' / ';
                        echo Html::a('Regístrate', ['/users/singup']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar-inverse navbar-bocconcini navbar affix-top" id="topnavbar">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">Bocconcini</a>
            </div>


            <div class="collapse navbar-collapse js-navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="dropdown mega-dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catalogo<span class="glyphicon glyphicon-chevron-down pull-right"></span></a>

                  <ul class="dropdown-menu mega-dropdown-menu row">
                      <li class="col-sm-1"></li>
                    <?php foreach($categories as $category){ ?>
                    <li class="col-sm-2">
                      <ul>
                        <li class="dropdown-header"><?= $category->name ?></li>
                        <div id="myCarousel" class="carousel slide <?= (empty($category->imagen)) ? 'hide' : '' ?>" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="item active">
                                <a href="#"><img src="<?= BaseUrl::base().'/uploads/categories/'.$category->id.'.'.$category->imagen ?>" class="img-responsive" alt="product 1"></a>
                            </div>
                            <!-- End Item -->
                          </div>
                          <!-- End Carousel Inner -->
                        </div>
                        <!-- /.carousel -->
                        <li class="divider"></li>
                        <li><a href="<?= BaseUrl::base().'/index.php?r=product/searchbycategory&categoryid='.$category->id ?>">Ver <?= $category->name ?> <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
                      </ul>
                    </li>
                    <?php }?>
                  </ul>

                </li>
              </ul>
                <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->roleid == 1){?> 
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown mega-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                            <ul class="dropdown-menu mega-dropdown-menu row">
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Productos</li>
                                        <li class="divider"></li>
                                        <li><?= Html::a('Categorías', ['/productcategory']) ?></li>
                                        <li><?= Html::a('Productos', ['/product']) ?></li>
                                        <li><?= Html::a('Imagen de productos', ['/productimage']) ?></li>
                                        <li><?= Html::a('Descuentos', ['/discount']) ?></li>
                                        <li><?= Html::a('Productos en Descuento', ['/discountproduct'])?></li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Sitio</li>
                                        <li class="divider"></li>
                                        <li><?= Html::a('Ubicación Banner', ['/bannerlocation']) ?></li>
                                        <li><?= Html::a('Banner', ['/banner']) ?></li>
                                        <li><?= Html::a('Usuarios', ['/users']) ?></li>
                                        <li><?= Html::a('Roles', ['/role']) ?></li>
                                        <li><?= Html::a('Direcciones de usuarios', ['/useraddress'])?></li>
                                        <li><?= Html::a('Departamentos', ['/municipality'])?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
                <?php if(!Yii::$app->user->isGuest){?> 
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown mega-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= Yii::$app->user->identity->name?><span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                            <ul class="dropdown-menu mega-dropdown-menu row">
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Perfil</li>
                                        <li class="divider"></li>
                                        <li><?= Html::a( Yii::$app->user->identity->name, ['/users/profile']) ?></li>
                                        <li><?= Html::a( 'Modificar Perfil', ['/users/updateprofile']) ?></li>
                                        <li><?= Html::a( 'Cerrar sesión', ['/site/logout']) ?></li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Carrito de compras</li>
                                        <li class="divider"></li>
                                    </ul>
                                </li>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header">Favoritos</li>
                                        <li class="divider"></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php }else{ ?>
                    <ul class="nav navbar-nav pull-right">
                        <li><?= Html::a('Productos', ['/product']) ?></li>
                    </ul>
                <?php } ?>
            </div>
        </div>
        <!-- /.nav-collapse -->
      </nav>
    <?php
    NavBar::begin([
        'brandLabel' => 'Bocconcini',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-bocconcini hide',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Bocconcini <?= date('Y') ?></p>
        <p class="pull-right"><a href="https://www.facebook.com/Bocconcini-Sorpresas-303320096479255/" title="Facebook" class="red-social" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></p>
        <p class="pull-right"><a href="https://www.instagram.com/bocconcini.sorpresas/" title="Instagram" class="red-social" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></p>
        <!--<p class="pull-right"><?= Yii::powered() ?></p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
