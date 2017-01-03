<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bannerlocation */

$this->title = 'Bocconcini | Admin';
$this->params['breadcrumbs'][] = ['label' => 'Ubicación de Banners', 'url' => ['index']];
$PT = 'Crear';
$this->params['breadcrumbs'][] = $PT;
?>
<div class="bannerlocation-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
