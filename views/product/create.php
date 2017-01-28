<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="product-create">

    <h1><?= Html::encode($PT) ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?php if(Yii::$app->session->getFlash('error_image') != null){?>
            <div class="alert alert-danger"><?= Yii::$app->session->getFlash('error_image') ?></div>
            <?php } ?>
        </div>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'queryProductCategory' => $queryProductCategory,
    ]) ?>

</div>
