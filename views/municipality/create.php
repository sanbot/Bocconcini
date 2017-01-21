<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Municipality */

$this->title = 'Bocconcini | Admin';
$PT = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Minicipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="municipality-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
