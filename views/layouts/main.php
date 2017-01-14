<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Bocconcini',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-bocconcini navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Nosotros', 'url' => ['/site/about']],
            ['label' => 'Contáctenos', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (''): Yii::$app->user->identity->roleid == 1 ? ([
                'label' => 'Productos',
                'items' => [
                    ['label' => 'Categorías', 'url' => ['/productcategory']],
                    ['label' => 'Productos', 'url' => ['/product']],
                    ['label' => 'Imagen de productos', 'url' => ['/productimage']],
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
                ],
            ]): (''),
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : ([
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
