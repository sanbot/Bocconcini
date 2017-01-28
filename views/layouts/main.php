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
    <?php
    NavBar::begin([
        'brandLabel' => 'Bocconcini',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-bocconcini',
            'id' => 'topnavbar'
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (''): Yii::$app->user->identity->roleid == 1 ? ([
                'label' => 'Productos',
                'items' => [
                    ['label' => 'Categorías', 'url' => ['/productcategory']],
                    ['label' => 'Productos', 'url' => ['/product']],
                    ['label' => 'Imagen de productos', 'url' => ['/productimage']],
                    ['label' => 'Descuentos', 'url' => ['/discount']],
                    ['label' => 'Productos en Descuento', 'url' => ['/discountproduct']],
                ],
            ]): (
                ['label' => 'Productos', 'url' => ['/product']]
            ),
            Yii::$app->user->isGuest ? (''): Yii::$app->user->identity->roleid == 1 ? ([
                'label' => 'Admin',
                'items' => [
                    ['label' => 'Ubicación Banner', 'url' => ['/bannerlocation']],
                    ['label' => 'Banner', 'url' => ['/banner']],
                    ['label' => 'Usuarios', 'url' => ['/users']],
                    ['label' => 'Roles', 'url' => ['/role']],
                    ['label' => 'Direcciones de usuarios', 'url' => ['/useraddress']],
                    ['label' => 'Departamentos', 'url' => ['/municipality']],
                ],
            ]): (''),
            Yii::$app->user->isGuest ? ('') : ([
                'label' => Yii::$app->user->identity->name,
                'items' => [
                    ['label' => 'Perfil', 'url' => ['/users/profile']],
                    ['label' => 'Carrito de compras', 'url' => ['/site']],
                    ['label' => 'Logout', 'url' => ['/site/logout']],
                ],
            ])
        ],
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

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
