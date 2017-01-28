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

AppAsset::register($this);
$img = Banner::find()->where('location = 2')->one();
if(!isset($img)){
    $img = new stdClass();
    $img->id = '';
    $img->extension = '';
}
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
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Collection <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>

                  <ul class="dropdown-menu mega-dropdown-menu row">
                    <li class="col-sm-3">
                      <ul>
                        <li class="dropdown-header">New in Stores</li>
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                          <div class="carousel-inner">
                            <div class="item active">
                              <a href="#"><img src="http://placehold.it/254x150/3498db/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 1"></a>
                              <h4><small>Summer dress floral prints</small></h4>
                              <button class="btn btn-primary" type="button">49,99 €</button>
                              <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
                            </div>
                            <!-- End Item -->
                            <div class="item">
                              <a href="#"><img src="http://placehold.it/254x150/ef5e55/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 2"></a>
                              <h4><small>Gold sandals with shiny touch</small></h4>
                              <button class="btn btn-primary" type="button">9,99 €</button>
                              <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
                            </div>
                            <!-- End Item -->
                            <div class="item">
                              <a href="#"><img src="http://placehold.it/254x150/2ecc71/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 3"></a>
                              <h4><small>Denin jacket stamped</small></h4>
                              <button class="btn btn-primary" type="button">49,99 €</button>
                              <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>
                            </div>
                            <!-- End Item -->
                          </div>
                          <!-- End Carousel Inner -->
                        </div>
                        <!-- /.carousel -->
                        <li class="divider"></li>
                        <li><a href="#">View all Collection <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
                      </ul>
                    </li>
                    <li class="col-sm-3">
                      <ul>
                        <li class="dropdown-header">Dresses</li>
                        <li><a href="#">Unique Features</a></li>
                        <li><a href="#">Image Responsive</a></li>
                        <li><a href="#">Auto Carousel</a></li>
                        <li><a href="#">Newsletter Form</a></li>
                        <li><a href="#">Four columns</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Tops</li>
                        <li><a href="#">Good Typography</a></li>
                      </ul>
                    </li>
                    <li class="col-sm-3">
                      <ul>
                        <li class="dropdown-header">Jackets</li>
                        <li><a href="#">Easy to customize</a></li>
                        <li><a href="#">Glyphicons</a></li>
                        <li><a href="#">Pull Right Elements</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Pants</li>
                        <li><a href="#">Coloured Headers</a></li>
                        <li><a href="#">Primary Buttons & Default</a></li>
                        <li><a href="#">Calls to action</a></li>
                      </ul>
                    </li>
                    <li class="col-sm-3">
                      <ul>
                        <li class="dropdown-header">Accessories</li>
                        <li><a href="#">Default Navbar</a></li>
                        <li><a href="#">Lovely Fonts</a></li>
                        <li><a href="#">Responsive Dropdown </a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Newsletter</li>
                        <form class="form" role="form">
                          <div class="form-group">
                            <label class="sr-only" for="email">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email">
                          </div>
                          <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </form>
                      </ul>
                    </li>
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
                                        <li><?= Html::a( 'Cerrar sesión', ['/users/logout']) ?></li>
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
