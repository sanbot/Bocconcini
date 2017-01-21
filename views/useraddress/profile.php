<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Useraddress */

$this->title = 'Bocconcini';
$PT = 'Dirección de perfil';
$this->params['breadcrumbs'][] = ['label' => 'Direcciones de usuario'];
$this->params['breadcrumbs'][] = $PT;
?>
<div class="useraddress-create">

    <h1><?= Html::encode($PT) ?></h1>

    <?= $this->render('_formaddtoprofile', [
        'model' => $model,
        'queryMunicipality' => $queryMunicipality,
    ]) ?>

</div>
